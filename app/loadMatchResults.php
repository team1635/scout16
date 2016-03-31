<?php

require_once 'token_info.php';
require_once 'infodb.php';
require_once 'scoutUtil.php';

$post_data = file_get_contents("php://input"); //debug

if (defined('STDIN')) {
  $event_code_param = $argv[1];
  $match_type_param = $argv[2];
  $match_number_param = $argv[3];
} else { 
  if (
    isset($_POST['event_code']) && isset($_POST['match_type'])
    && isset($POST['match_number'])
  ) {
    $event_code_param = SanitizeString($_POST['event_code']);
    $match_type_param = SanitizeString($_POST['match_type']);
    $match_number_param = SanitizeString($_POST['match_number']);      
  }
}

$db_server = mysql_connect($db_hostname, $db_username , $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());
  
if (empty($event_code_param)) {
    $last_saved_match = get_last_saved();
} else {
  if (($match_type_param !== 'qualifications') and
    ($match_type_param) !== 'practice') {
    die("<p>Can only update 'qualifications' or 'practice' matches.</p>");
  }
  
  $last_saved_match = array(
    'event_id' => get_event_id($event_code_param)
    , 'event_code' => $event_code_param
    , 'match_type' => $match_type_param
    , 'api_match_type' => get_api_match_type($match_type_param)
    , 'match_number' => $match_number_param  
  );
}

$result_str = get_result_xml($last_saved_match, $token);
$match_cnt = parse_xml_result($result_str, $last_saved_match);
$prev_last_saved_match = $last_saved_match['match_number'];

$new_last_saved_match = $prev_last_saved_match + $match_cnt - 1;
update_last_saved_match($new_last_saved_match);
echo "<p>Updated last saved match to $new_last_saved_match</p>\n";

function get_last_saved() {
  $query = "SELECT e.id, e.code, c.match_type, c.last_saved_result "
    . "FROM current_ c "
    . "  JOIN event e "
    . "    ON c.event_code = e.code ";

  $result = mysql_query($query);

  //echo "<p>$query</p>"; //debug
  if (!$result) die("Cannot retrieve last saved match: " . mysql_error());

  $match_number = mysql_result($result, 0, 'last_saved_result') + 1;
  $match_type = mysql_result($result, 0, 'match_type');
  return array(
    'event_id' => mysql_result($result, 0, 'id')
    , 'event_code' => mysql_result($result, 0, 'code')
    , 'match_type' => $match_type
    , 'api_match_type' => get_api_match_type($match_type)
    , 'match_number' => $match_number
  );

}

function get_api_match_type($front_end_match_type) {
  $ret_match_type = 'qual';
  if (($front_end_match_type == 'qualifications') or
      ($front_end_match_type == 'qualificat')) {
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

function get_result_xml($last_saved_match, $token) {
//TODO: get multiple match numbers (how many? all?)
  $ch = curl_init();
  $url = build_url(
    $last_saved_match['event_code']
    , $last_saved_match['api_match_type']
    , $last_saved_match['match_number']
  );
  
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //debug on local machine

  $enc_token = base64_encode($token);

  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Accept: application/xml",
    "Authorization: Basic " . $enc_token
  ));

  $response = curl_exec($ch);
  if ($response === false) {
    die("<p>curl error is:" . curl_error($ch) ."</p>\n"); 
  }

  curl_close($ch);

  return $response;
}

function build_url($event_code, $match_type, $match_number) {
    //https://frc-api.firstinspires.org/v2.0/2016/scores/
    //NYNY/qual?teamNumber=teamNumber&matchNumber=matchNumber&start=start&end=end

    return "https://frc-api.firstinspires.org/v2.0/2016/scores/"
      . $event_code . "/". $match_type
//      . "?matchNumber=" . $match_number;
      . "?start=" . $match_number;
}

function parse_xml_result($xml_str, $last_saved_match) {
  $match_cnt = 0;
  
  if (!$xml_str) die("<p>No response from frc-events server</p>\n"); 

  $event_id = $last_saved_match['event_id'];
  $match_type = $last_saved_match['match_type'];
  $match_number = $last_saved_match['match_number'];
  
  //var_dump($xml_str); //debug
  $env = new SimpleXMLElement($xml_str);

  foreach ($env->MatchScores->Score_2016 as $match_score) { 
    $match_cnt = $match_cnt + 1;
    process_match($match_score, $event_id, $match_type);
  }

  return $match_cnt;
}

function process_match($score, $event_id, $match_type) {

  $red_result = array(
    'auto_high_goal' => 0
    , 'auto_low_goal' => 0
    , 'auto_cross_defense' => 0
    , 'breach' => 0
    , 'capture' => 0
    , 'fouls' => 0
    , 'cross_low_bar' => 0
    , 'def2' => ""
    , 'cross_def2' => 0
    , 'def3' => ""
    , 'cross_def3' => 0
    , 'def4' => ""
    , 'cross_def4' => 0
    , 'def5' => ""
    , 'cross_def5' => 0
    , 'auto_1_reach_defense' => ""
    , 'auto_2_reach_defense' => ""
    , 'auto_3_reach_defense' => ""
    , 'score_high' => 0
    , 'score_low' => 0
    , 'tower_1_status' => ""
    , 'tower_2_status' => ""
    , 'tower_3_status' => ""    
  );
  $blue_result = $red_result;

  //echo "{$env->MatchScores->Score_2016->Alliances->Alliance}\n"; //debug
  //$match_score->Alliances->Alliance as $alliance //debug
  foreach ($score->Alliances->Alliance as $alliance) {
      $alliance_color = $alliance->alliance;
      if ($alliance_color == 'Red') {
        $red_result['auto_high_goal'] = if_empty_zero($alliance->autoBoulderHigh);
        $red_result['auto_low_goal'] = if_empty_zero($alliance->autoBoulderLow);
        $red_result['auto_cross_defense'] = if_empty_zero($alliance->autoCrossingPoints);
        $red_result['breach'] = if_empty_zero($alliance->breachPoints);
        $red_result['capture'] = if_empty_zero($alliance->capturePoints);
        $red_result['fouls'] = if_empty_zero($alliance->foulCount);
        $red_result['cross_low_bar'] = if_empty_zero($alliance->position1crossings);
        $red_result['def2'] = $alliance->position2;
        $red_result['cross_def2'] = if_empty_zero($alliance->position2crossings);
        $red_result['def3'] = $alliance->position3;
        $red_result['cross_def3'] = if_empty_zero($alliance->position3crossings);
        $red_result['def4'] = $alliance->position4;
        $red_result['cross_def4'] = if_empty_zero($alliance->position4crossings);
        $red_result['def5'] = $alliance->position5;
        $red_result['cross_def5'] = if_empty_zero($alliance->position5crossings);
        $red_result['auto_1_reach_defense'] = $alliance->robot1Auto;
        $red_result['auto_2_reach_defense'] = $alliance->robot2Auto;
        $red_result['auto_3_reach_defense'] = $alliance->robot3Auto;
        $red_result['score_high'] = if_empty_zero($alliance->teleopBouldersHigh);
        $red_result['score_low'] = if_empty_zero($alliance->teleopBouldersLow);
        $red_result['tower_1_status'] = $alliance->towerFaceA;
        $red_result['tower_2_status'] = $alliance->towerFaceB;
        $red_result['tower_3_status'] = $alliance->towerFaceC;
      } else {
        $blue_result['auto_high_goal'] = if_empty_zero($alliance->autoBoulderHigh);
        $blue_result['auto_low_goal'] = if_empty_zero($alliance->autoBoulderLow);
        $blue_result['auto_cross_defense'] = if_empty_zero($alliance->autoCrossingPoints);
        $blue_result['breach'] = if_empty_zero($alliance->breachPoints);
        $blue_result['capture'] = if_empty_zero($alliance->capturePoints);
        $blue_result['fouls'] = if_empty_zero($alliance->foulCount);
        $blue_result['cross_low_bar'] = if_empty_zero($alliance->position1crossings);
        $blue_result['def2'] = $alliance->position2;
        $blue_result['cross_def2'] = if_empty_zero($alliance->position2crossings);
        $blue_result['def3'] = $alliance->position3;
        $blue_result['cross_def3'] = if_empty_zero($alliance->position3crossings);
        $blue_result['def4'] = $alliance->position4;
        $blue_result['cross_def4'] = if_empty_zero($alliance->position4crossings);
        $blue_result['def5'] = $alliance->position5;
        $blue_result['cross_def5'] = if_empty_zero($alliance->position5crossings);
        $blue_result['auto_1_reach_defense'] = $alliance->robot1Auto;
        $blue_result['auto_2_reach_defense'] = $alliance->robot2Auto;
        $blue_result['auto_3_reach_defense'] = $alliance->robot3Auto;
        $blue_result['score_high'] = if_empty_zero($alliance->teleopBouldersHigh);
        $blue_result['score_low'] = if_empty_zero($alliance->teleopBouldersLow);
        $blue_result['tower_1_status'] = $alliance->towerFaceA;
        $blue_result['tower_2_status'] = $alliance->towerFaceB;
        $blue_result['tower_3_status'] = $alliance->towerFaceC;
      }
  }

  $match_number = $score->matchNumber;
  
  insert_result($event_id, $match_type, $match_number 
    , $red_result, $blue_result);
}

function if_empty_zero($value) {
  $ret_value = 0;
  if (! empty($value)) {
      $ret_value = $value;
  }   
  
  return $ret_value;
}

function insert_result($event_id, $match_type, $match_number
  , $red_result, $blue_result
) {
  $query = "INSERT match_result ( "
           . '  event_id, type_, number_ '
           . ', red_auto_high_goal, red_auto_low_goal, red_auto_cross_defense '
           . ', red_breach, red_capture, red_fouls '
           . ', red_cross_low_bar, red_def2, red_cross_def2 '
           . ', red_def3, red_cross_def3 '
           . ', red_def4, red_cross_def4 '
           . ', red_def5, red_cross_def5 '  
           . ', red_auto_1_reach_defense, red_auto_2_reach_defense, red_auto_3_reach_defense '
           . ', red_score_high, red_score_low '
           . ', red_tower_1_status, red_tower_2_status, red_tower_3_status '
           . ', blue_auto_high_goal, blue_auto_low_goal, blue_auto_cross_defense '
           . ', blue_breach, blue_capture, blue_fouls '
           . ', blue_cross_low_bar, blue_def2, blue_cross_def2 '
           . ', blue_def3, blue_cross_def3 '
           . ', blue_def4, blue_cross_def4 '
           . ', blue_def5, blue_cross_def5 '  
           . ', blue_auto_1_reach_defense, blue_auto_2_reach_defense, blue_auto_3_reach_defense '
           . ', blue_score_high, blue_score_low '
           . ', blue_tower_1_status, blue_tower_2_status, blue_tower_3_status '
           . ') VALUES ('
           . " $event_id, '$match_type', $match_number "
           . "  , " . $red_result['auto_high_goal']
           . "  , " . $red_result['auto_low_goal']
           . "  , " . $red_result['auto_cross_defense']
           . "  , " . $red_result['breach']
           . "  , " . $red_result['capture']
           . "  , " . $red_result['fouls']
           . "  , " . $red_result['cross_low_bar']
           . "  , '" . $red_result['def2'] . "' "
           . "  , " . $red_result['cross_def2']
           . "  , '" . $red_result['def3'] . "' "
           . "  , " . $red_result['cross_def3']
           . "  , '" . $red_result['def4'] . "' "
           . "  , " . $red_result['cross_def4']
           . "  , '" . $red_result['def5'] . "' "
           . "  , " . $red_result['cross_def5']
           . "  , '" . $red_result['auto_1_reach_defense'] . "' "
           . "  , '" . $red_result['auto_2_reach_defense'] . "' "
           . "  , '" . $red_result['auto_3_reach_defense'] . "' "
           . "  , " . $red_result['score_high']
           . "  , " . $red_result['score_low']
           . "  , '" . $red_result['tower_1_status'] . "' "
           . "  , '" . $red_result['tower_2_status'] . "' "
           . "  , '" . $red_result['tower_3_status'] . "' "

           . "  , " . $blue_result['auto_high_goal']
           . "  , " . $blue_result['auto_low_goal']
           . "  , " . $blue_result['auto_cross_defense']
           . "  , " . $blue_result['breach']
           . "  , " . $blue_result['capture']
           . "  , " . $blue_result['fouls']
           . "  , " . $blue_result['cross_low_bar']
           . "  , '" . $blue_result['def2'] . "' "
           . "  , " . $blue_result['cross_def2']
           . "  , '" . $blue_result['def3'] . "' "
           . "  , " . $blue_result['cross_def3']
           . "  , '" . $blue_result['def4'] . "' "
           . "  , " . $blue_result['cross_def4']
           . "  , '" . $blue_result['def5'] . "' "
           . "  , " . $blue_result['cross_def5']
           . "  , '" . $blue_result['auto_1_reach_defense'] . "' "
           . "  , '" . $blue_result['auto_2_reach_defense'] . "' "
           . "  , '" . $blue_result['auto_3_reach_defense'] . "' "
           . "  , " . $blue_result['score_high']
           . "  , " . $blue_result['score_low']
           . "  , '" . $blue_result['tower_1_status'] . "' "
           . "  , '" . $blue_result['tower_2_status'] . "' "
           . "  , '" . $blue_result['tower_3_status'] . "' )";

  //echo "<p>$query</p>\n"; //debug
  $result = mysql_query($query);
  if (!$result) die("<p>Score insert failed: " . mysql_error() . "</p>");
}

function update_last_saved_match($match) {
  $query = "UPDATE current_ SET last_saved_result = " . $match;

  $result = mysql_query($query);
  if (!$result) die("Failed to save last match result loaded: " + mysql_error()); 
}


?>