<?php

require_once 'infodb.php';

(isset($_POST['team_id']) && isset($_POST['match__id'])) or
  die("<p>Need at least a team number and a match number.</p>");

$team_id = SanitizeString($_POST['team_id']);
$match__id = SanitizeString($_POST['match__id']);

$auto_position = SanitizeString($_POST['auto_position']);
$auto_reach = SanitizeString($_POST['auto_reach']);
$auto_cross = SanitizeString($_POST['auto_cross']);
$auto_low = SanitizeString($_POST['auto_low']);
$auto_high = SanitizeString($_POST['auto_high']);

$cross_low_bar = SanitizeString($_POST['cross_low_bar']);
$cross_def2 = SanitizeString($_POST['cross_def2']);
$cross_def3 = SanitizeString($_POST['cross_def3']);
$cross_def4 = SanitizeString($_POST['cross_def4']);
$cross_def5 = SanitizeString($_POST['cross_def5']);
$open_def2 = SanitizeString($_POST['open_def2']);
$open_def3 = SanitizeString($_POST['open_def3']);
$open_def4 = SanitizeString($_POST['open_def4']);
$open_def5 = SanitizeString($_POST['open_def5']);
$pick_ball = SanitizeString($_POST['pick_ball']);
$pass_ball = SanitizeString($_POST['pass_ball']);

$score_low = SanitizeString($_POST['score_low']);
$score_high = SanitizeString($_POST['score_high']);
$reach_twr = SanitizeString($_POST['reach_twr']);
$climb_twr = SanitizeString($_POST['climb_twr']);

$defense = SanitizeString($_POST['defense']);
$fouls = SanitizeString($_POST['fouls']);

$db_server = mysql_connect($db_hostname, $db_username , $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());

$query = "INSERT stat (team_id, match__id, auto_position "
         . "  , auto_reach_defense, auto_cross_defense, auto_low_goal "
         . "  , auto_high_goal, cross_low_bar, cross_defense2 "
         . "  , cross_defense3, cross_defense4, cross_defense5 "
         . "  , open_defense2, open_defense3, open_defense4 "
         . "  , open_defense5, pick_boulder, pass_boulder "
         . "  , score_low, score_high, get_on_tower "
         . "  , climb_tower, defense, fouls ) "
         . "VALUES ($team_id, '$match__id', $auto_position "
         . "  , $auto_reach, $auto_cross, $auto_low "
         . "  , $auto_high, $cross_low_bar, $cross_def2 "
         . "  , $cross_def3, $cross_def4, $cross_def5 "
         . "  , $open_def2, $open_def3, $open_def4 "
         . "  , $open_def5, $pick_ball, $pass_ball "
         . "  , $score_low, $score_high, $reach_twr "
         . "  , $climb_twr, $defense, $fouls ) ";

$result = mysql_query($query);
//echo "<p>$query</p>"; //debug
if (!$result) die("Database access failed: " . mysql_error());

echo "<p>Team $team_id stats for match id $match__id saved.</p>"; 

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