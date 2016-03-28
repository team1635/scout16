<?php

require_once 'infodb.php';
require_once 'scoutUtil.php';

$post_data = file_get_contents("php://input");

if (defined('STDIN')) {
  $cur_event_cd = $argv[1];
  $cur_match_type = $argv[2];
  $cur_match_nr = $argv[3];
  $red_def2 = $argv[4];
  $red_def3 = $argv[5];
  $red_def4 = $argv[6];
  $red_def5 = $argv[7];
  $blue_def2 = $argv[8];
  $blue_def3 = $argv[9];
  $blue_def4 = $argv[10];
  $blue_def5 = $argv[11];
} else {
  (
    isset($_POST['cur_event_cd']) && isset($_POST['cur_match_type'])
      && isset($_POST['cur_match_nr'])
  ) or
  die("<p>Event code, match type and current match must be populated.</p>");
   
  (
    isset($_POST['red_def2']) && isset($_POST['red_def3'])
      && isset($_POST['red_def4']) && isset($_POST['red_def5']) 
      && isset($_POST['blue_def2']) && isset($_POST['blue_def3'])
      && isset($_POST['blue_def4']) && isset($_POST['blue_def5'])
  ) or
    die("<p>All defenses must filled in to be saved.</p>");

  $cur_event_cd = SanitizeString($_POST['cur_event_cd']);
  $cur_match_type = SanitizeString($_POST['cur_match_type']);
  $cur_match_nr = SanitizeString($_POST['cur_match_nr']);  
  $red_def2 = SanitizeString($_POST['red_def2']);
  $red_def3 = SanitizeString($_POST['red_def3']);
  $red_def4 = SanitizeString($_POST['red_def4']);
  $red_def5 = SanitizeString($_POST['red_def5']);
  $blue_def2 = SanitizeString($_POST['blue_def2']);
  $blue_def3 = SanitizeString($_POST['blue_def3']);
  $blue_def4 = SanitizeString($_POST['blue_def4']);
  $blue_def5 = SanitizeString($_POST['blue_def5']);
}

$db_server = mysql_connect($db_hostname, $db_username , $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());

$cur_event_id = get_event_id($cur_event_cd);
//TODO: check that we got reasonable event_id

$query2 = "UPDATE match_ "
         . "SET red_def2 = '$red_def2' "
         . "  , red_def3 = '$red_def3' "
         . "  , red_def4 = '$red_def4' "
         . "  , red_def5 = '$red_def5' "
         . "  , blue_def2 = '$blue_def2' "
         . "  , blue_def3 = '$blue_def3' "
         . "  , blue_def4 = '$blue_def4' "
         . "  , blue_def5 = '$blue_def5' "
         . "WHERE event_id = $cur_event_id "
         . "  AND type_ = '$cur_match_type' "
         . "  AND number_ = $cur_match_nr ";

$result2 = mysql_query($query2);
//echo "<p>$query2</p>"; //debug
if (!$result2) die("Match update failed: " . mysql_error());

echo "<p>Defenses have been set for match number $cur_match_nr.</p>"; 

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

?>