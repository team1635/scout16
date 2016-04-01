<?php

require_once 'infodb.php';
require_once 'scoutUtil.php';

$post_data = file_get_contents("php://input");

if (defined('STDIN')) {
  $cur_event_cd = $argv[1];
  $cur_match_type = $argv[2];
  $cur_match_nr = $argv[3];
} else {
  (
    isset($_POST['cur_event_cd']) && isset($_POST['cur_match_type'])
      && isset($_POST['cur_match_nr'])
  ) or
    die("<p>Event code, match type and current match must be populated.</p>");
  
  $cur_event_cd = SanitizeString($_POST['cur_event_cd']);
  $cur_match_type = SanitizeString($_POST['cur_match_type']);
  $cur_match_nr = SanitizeString($_POST['cur_match_nr']);
}

$db_server = mysql_connect($db_hostname, $db_username , $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());

$query = "UPDATE current_ "
         . "  SET event_code = '$cur_event_cd' "
         . "  , match_type = '$cur_match_type' "
         . "  , match_number = '$cur_match_nr' ";

$result = mysql_query($query);
//echo "<p>$query</p>"; //debug
if (!$result) die("Current match update failed: " . mysql_error());

recompute_flat_stat();

echo "<p>Event code $cur_event_cd, match type $cur_match_type"
  . " and match number $cur_match_nr are now the current defaults.</p>"; 

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

function recompute_flat_stat() {
  $query = "TRUNCATE TABLE flat_stat";
  $result = mysql_query($query);
  //echo "<p>$query</p>"; //debug
  if (!$result) die("Error truncating flat_stat: " . mysql_error());

  $base_red_query = file_get_contents("fix_def_red.sql");

  for ($i = 1; $i < 4; $i++) {
    $sql_script_file = "fix_def_red".$i.".sql";
    $query = $base_red_query . file_get_contents($sql_script_file);
    $result = mysql_query($query);
    //echo "<p>$query</p>"; //debug
    if (!$result) die("Error running sql script ($sql_script_file): " . mysql_error());
  }

  $base_blue_query = file_get_contents("fix_def_blue.sql");

  for ($i = 1; $i < 4; $i++) {
    $sql_script_file = "fix_def_blue".$i.".sql";
    $query = $base_red_query . file_get_contents($sql_script_file);
    $result = mysql_query($query);
    //echo "<p>$query</p>"; //debug
    if (!$result) die("Error running sql script ($sql_script_file): " . mysql_error());
  }

  echo "<p>Recomputed flat_stat</p>\n"; 
}

?>