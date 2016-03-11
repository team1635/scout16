<?php

require_once 'token_info.php';
require_once 'infodb.php';

$post_data = file_get_contents("php://input"); //debug

(isset($_POST['event_code']) && isset($_POST['match_type'])) or
  die("<p>Need event code and match type to load matches. Got $post_data</p>");

//$event_code_param = 'WAAMV';
//$match_type_param = 'qualification';

$event_code_param = SanitizeString($_POST['event_code']);
$match_type_param = SanitizeString($_POST['match_type']);

if ($match_type_param !== 'qualifications' and
    $match_type_param !== 'practice') {
  die("<p>Can only load 'qualifications' or 'practice' matches.</p>");
}

$db_server = mysql_connect($db_hostname, $db_username , $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());
  
$event_id = get_event_id($event_code_param);
//TODO: check that we got reasonable event_id

$match_cnt = 0;
$team_cnt = 0;

$matches_str = get_schedule_xml($event_code, $match_type);
$match_cnt = parse_xml_schedule($matches_str, $event_id, $match_type);

if ($found_table === 0) {
  die("<p> Error: target table not found </p>"); 
} 

foreach ($table_html->find('tr') as $row) {
  if ($row->parent->tag == 'tbody') {
  }
}

echo "<p>Loaded $match_cnt matches<p>Loaded $team_cnt teams\n";

//TODO: add event to the match table. 
//TODO: parse event id from the URL passed

function save_match($event_id, $match_type, $match_id
  , $red_team1, $red_team2, $red_team3
  , $blue_team1, $blue_team2, $blue_team3
) {
  $query = "INSERT match_ (event_id, type_, number_ "
           . "  , red_team1_id, red_team2_id, red_team3_id"
           . "  , blue_team1_id, blue_team2_id, blue_team3_id) "
           . "VALUES ($event_id, '$match_type', $match_id "
           . "  , $red_team1, $red_team2, $red_team3 "
           . "  , $blue_team1, $blue_team2, $blue_team3)";

  $result = mysql_query($query);
  //echo "<p>$query</p>"; //debug
  if (!$result) die("Database access failed: " . mysql_error());
}

function build_url($event_code, $match_type) {
    //"https://frc-api.firstinspires.org/v2.0/2016/schedule/SCMB?tournamentLevel=qual"
    $api_match_type = 'qual';
  if ($match_type == 'qualifications') {
      $api_match_type = 'qual'
  } else {
      $api_match_type = 'playoff'
  }

    return "https://frc-api.firstinspires.org/v2.0/2016/schedule/" .
    $event_code . "?tournamentLevel=" . $match_type;
}

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

function get_event_id($event_code) {
  $query = "SELECT id "
           . "FROM event "
           . "WHERE code = '$event_code'";

  $result = mysql_query($query);
  if (!result) die("Database access failed: " + mysql_error()); 
  $rows = mysql_num_rows($result);
  //TODO: if we have no rows return 0 or null
  //TODO: if we have more than one row return problem

  return mysql_result($result, 0, 'id');
}

function get_schedule_xml($event_code, $match_type) {

  $ch = curl_init();
  $url = build_url($event_code, $match_type)

  curl_setopt($ch, CURLOPT_URL, );
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

function parse_xml_schedule($xml_str, $event_id, $match_type) {}
  $cnt = 0;
  $env = new SimpleXMLElement($xml_str);

  //echo "{$env->Schedule->ScheduledMatch[0]->description}\n";

  foreach ($env->Schedule->ScheduledMatch as $match) {
    $match_cnt = $match_cnt + 1;
    save_match($event_id, $match_type_param 
      , trim($row_cells[0]->plaintext), trim($row_cells[2]->plaintext)
      , trim($row_cells[3]->plaintext), trim($row_cells[4]->plaintext)
      , trim($row_cells[5]->plaintext), trim($row_cells[6]->plaintext)
      , trim($row_cells[7]->plaintext));
  }
?>

<?php
//getEventTeams.php
  require_once 'token_info.php';

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, "https://frc-api.firstinspires.org/v2.0/2016/teams?eventCode=SCMB");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);

  $enc_token = base64_encode($token);

  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Accept: application/xml",
    "Authorization: Basic " . $enc_token
  ));


  $response = curl_exec($ch);
  curl_close($ch);

  var_dump($response);
?>
