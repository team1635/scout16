<?php

require_once 'infodb.php';

(
  isset($_POST['cur_event_cd']) && isset($_POST['cur_match_type'])
  && isset($_POST['cur_match_nr'])
) or
  die("<p>Event code, match type and current match must be populated.</p>");
  
(
  isset($_POST['red_def2']) && isset($_POST['red_def3'])
  && isset($_POST['red_def4']) && isset($_POST['red_def5']) &&
  isset($_POST['blue_def2']) && isset($_POST['blue_def3'])
  && isset($_POST['blue_def4']) && isset($_POST['blue_def5'])

) or
  die("<p>Defenses must filled in to save the match match.</p>");

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

echo "<p>Event code $cur_event_cd, match type $cur_match_type"
  . " and match number $cur_match_nr are now the current defaults.</p>"; 

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

?>