<?php

require_once 'token_info.php';
require_once 'infodb.php';

$post_data = file_get_contents("php://input"); //debug

if (defined('STDIN')) {
  $event_code_param = $argv[1];
  $match_type_param = $argv[2];
  $match_number_param = $argv[3];
} else { 
  (
    isset($_POST['event_code']) && isset($_POST['match_type'])
    && isset($POST['match_number'])
  ) or
    die("<p>Need event code, match type and match number to update match defenses. Got $post_data</p>");

  $event_code_param = SanitizeString($_POST['event_code']);
  $match_type_param = SanitizeString($_POST['match_type']);
  $match_number_param = SanitizeString($_POST['match_number']);
}

if ($match_type_param !== 'qualifications' and
    $match_type_param !== 'practice') {
  die("<p>Can only update 'qualifications' or 'practice' matches.</p>");
}

$match_type = get_match_type($match_type_param);

$db_server = mysql_connect($db_hostname, $db_username , $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());
  
$event_id = get_event_id($event_code_param);
//TODO: check that we got reasonable event_id

$result_str = get_result_xml($event_code_param, $match_type, $match_number_param, $token);
$match_cnt = parse_xml_result($result_str, $event_id, $match_param_type, $match_number_param);

echo "<p>Updated defenses for match $match_number_param at event $event_code_param</p>\n";

//TODO: add event to the match table. 
//TODO: parse event id from the URL passed

function SanitizeString($var) {
    if (empty($var)) {
        $var = 'NULL';
    } else {
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripslashes($var);
    }
    return $var;
}

function get_match_type($front_end_match_type) {
  $ret_match_type = 'qual';
  if ($front_end_match_type == 'qualifications') {
      $ret_match_type = 'qual';
  } else {
      $ret_match_type = 'playoff';
  }

  return $ret_match_type;
}

function get_event_id($event_code) {
  $query = "SELECT id "
           . "FROM event "
           . "WHERE code = '$event_code'";

  $result = mysql_query($query);
  if (!$result) die("Failed to get event id from database: " + mysql_error()); 
  $rows = mysql_num_rows($result);
  //TODO: if we have no rows return 0 or null
  //TODO: if we have more than one row return problem

  return mysql_result($result, 0, 'id');
}

function get_result_xml($event_code, $match_type, $match_number, $token) {

  $ch = curl_init();
  $url = build_url($event_code, $match_type, $match_number);

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);

  $enc_token = base64_encode($token);

  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Accept: application/xml",
    "Authorization: Basic " . $enc_token
  ));

  $response = curl_exec($ch);
  curl_close($ch);

  return $response;
}

function build_url($event_code, $match_type, $match_number) {
    //https://frc-api.firstinspires.org/v2.0/2016/matches/NYNY?
    //tournamentLevel=qual&teamNumber=101&matchNumber=6&start=20&end=25
    //https://frc-api.firstinspires.org/v2.0/2016/scores/
    //NYNY/qual?teamNumber=teamNumber&matchNumber=matchNumber&start=start&end=end

    //return "https://frc-api.firstinspires.org/v2.0/2016/matches/" .
    return "https://frc-api.firstinspires.org/v2.0/2016/scores/"
      . $event_code . "/". $match_type
      . "?matchNumber=" . $match_number;
}

function parse_xml_result($xml_str, $event_id, $match_type, $match_number) {
  if (!$xml_str) die("<p>No response from frc-events server</p>\n"); 

  //var_dump($xml_str); //debug
  $env = new SimpleXMLElement($xml_str);
 
  $red_result = array(
    'auto_boulder_points' => 0
    , 'auto_boulder_high' => 0
    , 'auto_boulder_low' => 0
    , 'pos1_crossings' => 0
    , 'pos2' => ""
    , 'pos2_crossings' => 0
    , 'pos3' => ""
    , 'pos3_crossings' => 0
    , 'pos4' => ""
    , 'pos4_crossings' => 0
    , 'pos5' => ""
    , 'pos5_crossings' => 0
  );
  $blue_result = $red_result;

  //echo "{$env->MatchScores->Score_2016->Alliances->Alliance}\n"; //debug
  foreach ($env->MatchScores->Score_2016->Alliances->Alliance as $alliance) {
      $alliance_color = $alliance->alliance;
      echo "alliance color: $alliance_color\n"; //debug
      if ($alliance_color == 'Red') {
        echo "we are now under the red alliance processing\n"; //debug
        $red_result['auto_boulder_points'] = $alliance->autoBoulderPoints;
        $red_result['auto_boulder_high'] = $alliance->autoBoulderHigh;
        $red_result['auto_boulder_low'] = $alliance->autoBoulderLow;
        $red_result['pos1_crossings'] = $alliance->position1crossings;
        $red_result['pos2'] = $alliance->position2;
        $red_result['pos2_crossings'] = $alliance->position2crossings;
        $red_result['pos3'] = $alliance->position3;
        $red_result['pos3_crossings'] = $alliance->position3crossings;
        $red_result['pos4'] = $alliance->position4;
        $red_result['pos4_crossings'] = $alliance->position4crossings;
        $red_result['pos5'] = $alliance->position5;
        $red_result['pos5_crossings'] = $alliance->position5crossings;
      } else {
        echo "we are now under the blue alliance processing\n"; //debug
        $blue_result['auto_boulder_points'] = $alliance->autoBoulderPoints;
        $blue_result['auto_boulder_high'] = $alliance->autoBoulderHigh;
        $blue_result['auto_boulder_low'] = $alliance->autoBoulderLow;
        $blue_result['pos1_crossings'] = $alliance->position1crossings;
        $blue_result['pos2'] = $alliance->position2;
        $blue_result['pos2_crossings'] = $alliance->position2crossings;
        $blue_result['pos3'] = $alliance->position3;
        $blue_result['pos3_crossings'] = $alliance->position3crossings;
        $blue_result['pos4'] = $alliance->position4;
        $blue_result['pos4_crossings'] = $alliance->position4crossings;
        $blue_result['pos5'] = $alliance->position5;
        $blue_result['pos5_crossings'] = $alliance->position5crossings;          
      }

  }
  
  update_match($event_id, $match_type, $match_number 
    , $red_result, $blue_result);
}

function update_match($event_id, $match_type, $match_number
  , $red_result, $blue_result
) {
  $query = "UPDATE match_ "
           . "SET red_def2 = '" . $red_result['pos2'] . "' "
           . "  , red_def3 = '" . $red_result['pos3'] . "' "
           . "  , red_def4 = '" . $red_result['pos4'] . "' "
           . "  , red_def5 = '" . $red_result['pos5'] . "' "
           . "  , blue_def2 = '" . $blue_result['pos2'] . "' "
           . "  , blue_def3 = '" . $blue_result['pos3'] . "' "
           . "  , blue_def4 = '" . $blue_result['pos4'] . "' "
           . "  , blue_def5 = '" . $blue_result['pos5'] . "' "
           . "WHERE event_id = $event_id "
           . "  AND type_ = '$match_type' "
           . "  AND number_ = $match_number ";

  //$result = mysql_query($query);
  echo "<p>$query</p>"; //debug
  if (!$result) die("<p>Match update with defenses failed: " . mysql_error() . "</p>");
}

?>