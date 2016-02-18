<?php

require_once 'infodb.php';

(isset(
  $_POST['cur_event_cd']) && isset($_POST['cur_match_type'])
  && isset($_POST['cur_match_nr'])
) or
  die("<p>Event code, match type and current match must be populated.</p>");


$cur_event_cd = SanitizeString($_POST['cur_event_cd']);
$cur_match_type = SanitizeString($_POST['cur_match_type']);
$cur_match_nr = SanitizeString($_POST['cur_match_nr']);

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
if (!$result) die("Database access failed: " . mysql_error());

echo "<p>Event code $cur_event_cd, match type $cur_match_type"
  . " and match number $cur_match_nr are now the current defaults.</p>"; 

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

?>
