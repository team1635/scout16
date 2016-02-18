<html>
  <head>
    <title>Scout 15: Team report</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content=width=device-width, initial-scale=1">

    <link rel="stylesheet" href="lib/css/bootstrap.min.css" />
    <link rel="stylesheet" href="lib/css/main.css" />
  </head>
  <body>

<?php

require_once 'infodb.php';

$post_data = file_get_contents("php://input"); //debug

//isset($_POST['team_id']) or
isset($_GET['team_id']) or
  die("<p>Need team number. Got $post_data</p>");

$team_id = SanitizeString($_GET['team_id']);
//$team_id = 1635;

$db_server = mysql_connect($db_hostname, $db_username , $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());

$query =
"SELECT COUNT(*) as 'scouted_matches' " 
. "  , AVG(IFNULL(auto_robot,0)) as 'avg_auto_robot' "
. "  , AVG(IFNULL(auto_tote,0)) as 'avg_auto_tote' "
. "  , AVG(IFNULL(auto_can,0)) as 'avg_auto_can' "
. "  , AVG(IFNULL(auto_stack,0)) as 'avg_auto_stack' "
. "  , AVG(IFNULL(scored_gray,0)) as 'avg_scored_gray' "
. "  , AVG(IFNULL(scored_can_level,0)) as 'avg_scored_can_level' "
. "  , AVG(IFNULL(score_stack,0)) as 'avg_score_stack' " 
. "  , AVG(IFNULL(carry_stack,0)) as 'avg_carry_stack' "
. "  , AVG(IFNULL(handle_litter,0)) as 'avg_handle_litter' "
. "  , AVG(IFNULL(fallen_can,0)) as 'avg_fallen_can' " 
. "  , AVG(IFNULL(noodle_in_can,0)) as 'avg_noodle_in_can' "
. "  , AVG(IFNULL(clear_recycle,0)) as 'avg_clear_recycle' "
. "  , AVG(IFNULL(grab_step_can,0)) as 'avg_grab_step_can' " 
. "  , AVG(IFNULL(coop,0)) as 'avg_coop' "
. "  , AVG(IFNULL(coop_stack,0)) as 'avg_coop_stack' " 
. "  , AVG(IFNULL(fouls,0)) as 'avg_fouls' " 
. "FROM stat " 
. "WHERE team_id = $team_id ";

$result = mysql_query($query);
//echo "<p>$query</p>"; //debug
if (!$result) die("Database access failed: " . mysql_error());

echo "<div class=\"panel panel-default\">Scouting report for team $team_id";
echo '</div>';
echo '<table class="table table-striped"><tbody>';
echo "<tr><td>Scouted matches</td><td>";
echo mysql_result($result, 0, 'scouted_matches');
echo "</td></tr><tr><td>Auto Robot</td><td>";
echo mysql_result($result, 0, 'avg_auto_robot');
echo "</td></tr><tr><td>Auto Tote</td><td>";
echo mysql_result($result, 0, 'avg_auto_tote');
echo "</td></tr><tr><td>Auto Can</td><td>";
echo mysql_result($result, 0, 'avg_auto_can');
echo "</td></tr><tr><td>Auto Stack</td><td>";
echo mysql_result($result, 0, 'avg_auto_stack');
echo "</td></tr><tr><td>Scored Grey Totes</td><td>";
echo mysql_result($result, 0, 'avg_scored_gray');
echo "</td></tr><tr><td>Scored Can Level</td><td>";
echo mysql_result($result, 0, 'avg_scored_can_level');
echo "</td></tr><tr><td>Score Stack</td><td>";
echo mysql_result($result, 0, 'avg_score_stack'); 
echo "</td></tr><tr><td>Carry Stack</td><td>";
echo mysql_result($result, 0, 'avg_carry_stack');
echo "</td></tr><tr><td>Handle litter</td><td>";
echo mysql_result($result, 0, 'avg_handle_litter');
echo "</td></tr><tr><td>Picked fallen cans</td><td>";
echo mysql_result($result, 0, 'avg_fallen_can');
echo "</td></tr><tr><td>Noodle in can</td><td>";
echo mysql_result($result, 0, 'avg_noodle_in_can');
echo "</td></tr><tr><td>Cleared recycle area</td><td>";
echo mysql_result($result, 0, 'avg_clear_recycle');
echo "</td></tr><tr><td>Grabbed step cans</td><td>";
echo mysql_result($result, 0, 'avg_grab_step_can');
echo "</td></tr><tr><td>Coop tote</td><td>";
echo mysql_result($result, 0, 'avg_coop');
echo "</td></tr><tr><td>Coop stack</td><td>";
echo mysql_result($result, 0, 'avg_coop_stack');
echo "</td></tr><tr><td>Fouls</td><td>";
echo mysql_result($result, 0, 'avg_fouls');
echo "</td></tr></tbody></table>";

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
    <script src="lib/js/jquery-1.10.1.js"></script>
    <script src="lib/js/bootstrap.min.js"></script>
  </body>
</html>
