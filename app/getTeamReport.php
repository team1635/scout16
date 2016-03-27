<html>
  <head>
    <title>Scout 15: Team report</title>
    <meta charset="utf-8">\
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content=width=device-width, initial-scale=1">
    <link rel="stylesheet" href="lib/css/bootstrap.min.css" />
    <link rel="stylesheet" href="lib/css/main.css" />
  </head>
  <body>
<?php
require_once 'infodb.php';
$post_data = file_get_contents("php://input"); //debug
isset($_GET['team_id']) or
  die("<p>Need team number. Got $post_data</p>");
$team_id = SanitizeString($_GET['team_id']);

$db_server = mysql_connect($db_hostname, $db_username , $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());

$query =
"SELECT COUNT(*) as 'scouted_matches' " 
. "  , AVG(IFNULL(auto_reach_defense,0)) as 'avg_auto_reach_defense' "
. "  , AVG(IFNULL(auto_cross_defense,0)) as 'avg_auto_cross_defense' "
. "  , AVG(IFNULL(auto_low_goal,0)) as 'avg_auto_low_goal' "
. "  , AVG(IFNULL(auto_high_goal,0)) as 'avg_auto_high_goal' "

. "  , AVG(IFNULL(cross_low_bar,0)) as 'avg_cross_low_bar' "

. "  , AVG(IFNULL(pick_boulder,0)) as 'avg_pick_boulder' "
. "  , AVG(IFNULL(pass_boulder,0)) as 'avg_pass_boulder' " 
. "  , AVG(IFNULL(score_low,0)) as 'avg_score_low' "
. "  , AVG(IFNULL(score_high,0)) as 'avg_score_high' "
. "  , AVG(IFNULL(get_on_tower,0)) as 'avg_get_on_tower' " 
. "  , AVG(IFNULL(climb_tower,0)) as 'avg_climb_tower' "
. "  , AVG(IFNULL(defense,0)) as 'avg_defense' "
. "  , AVG(IFNULL(fouls,0)) as 'avg_fouls' " 
. "  , AVG(IFNULL(died,0)) as 'avg_deaths' " 
. "FROM stat " 
. "WHERE team_id = $team_id ";

$result = mysql_query($query);
//echo "<p>$query</p>"; //debug
if (!$result) die("Database query failed: " . mysql_error());

echo "<div class=\"panel panel-default\">Scouting report for team $team_id";
echo '</div>';

echo '<table class="table table-striped"><tbody>';
echo "<tr><td>Scouted matches</td><td>";
echo mysql_result($result, 0, 'scouted_matches');
echo "</td></tr><tr><td>Reach Defense in Auto</td><td>";
echo mysql_result($result, 0, 'avg_auto_reach_defense');
echo "</td></tr><tr><td>Cross Defense in Auto</td><td>";
echo mysql_result($result, 0, 'avg_auto_cross_defense');
echo "</td></tr><tr><td>Low Goal in Auto</td><td>";
echo mysql_result($result, 0, 'avg_auto_low_goal');
echo "</td></tr><tr><td>High Goal in Auto</td><td>";
echo mysql_result($result, 0, 'avg_auto_high_goal');

echo "</td></tr><tr><td>Cross Low Bar</td><td>";
echo mysql_result($result, 0, 'avg_cross_low_bar');

echo "</td></tr><tr><td>Pick Ball</td><td>";
echo mysql_result($result, 0, 'avg_pick_boulder');
echo "</td></tr><tr><td>Pass Ball</td><td>";
echo mysql_result($result, 0, 'avg_pass_boulder'); 
echo "</td></tr><tr><td>Score Low</td><td>";
echo mysql_result($result, 0, 'avg_score_low');
echo "</td></tr><tr><td>Score High</td><td>";
echo mysql_result($result, 0, 'avg_score_high');
echo "</td></tr><tr><td>Get on tower platform at end</td><td>";
echo mysql_result($result, 0, 'avg_get_on_tower');
echo "</td></tr><tr><td>Climb tower</td><td>";
echo mysql_result($result, 0, 'avg_climb_tower');
echo "</td></tr><tr><td>Defense moves</td><td>";
echo mysql_result($result, 0, 'avg_defense');
echo "</td></tr><tr><td>Fouls</td><td>";
echo mysql_result($result, 0, 'avg_fouls');
echo "</td></tr><tr><td>Deaths</td><td>";
echo mysql_result($result, 0, 'avg_deaths');
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

