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
require_once 'scoutUtil.php';

$post_data = file_get_contents("php://input"); //debug
if (defined('STDIN')) {
  $team_id = $argv[1];
} else { 
  if(isset($_GET['team_id'])) { 
    $team_id = SanitizeString($_GET['team_id']);
  }
}

$single_team = false;
if (! empty($team_id)) {
    $single_team = true;
}

$db_server = mysql_connect($db_hostname, $db_username , $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());

$query = "SELECT ";

if (! $single_team) {
    $query = $query . "team_id as 'team', ";
}

$query = $query
. "  CASE "
. "    WHEN stat.team_id IS NULL THEN 0 "
. "    ELSE COUNT(*) "
. "  END as 'scouted_matches' " 
. "  , AVG(IFNULL(auto_reach_defense,0)) as 'avg_auto_reach_defense' "
. "  , AVG(IFNULL(auto_cross_defense,0)) as 'avg_auto_cross_defense' "
. "  , AVG(IFNULL(auto_low_goal,0)) as 'avg_auto_low_goal' "
. "  , AVG(IFNULL(auto_high_goal,0)) as 'avg_auto_high_goal' "

. "  , AVG(IFNULL(cross_low_bar,0)) as 'avg_cross_low_bar' "
. "  , AVG(IFNULL(crossed_portcullis,0)) as 'avg_cross_portcullis' "
. "  , AVG(IFNULL(crossed_cheval,0)) as 'avg_cross_cheval' "
. "  , AVG(IFNULL(crossed_ramparts,0)) as 'avg_cross_ramparts' "
. "  , AVG(IFNULL(crossed_moat,0)) as 'avg_cross_moat' "
. "  , AVG(IFNULL(crossed_sally_port,0)) as 'avg_cross_sallyport' "
. "  , AVG(IFNULL(crossed_drawbridge,0)) as 'avg_cross_drawbridge' "
. "  , AVG(IFNULL(crossed_rock_wall,0)) as 'avg_cross_rockwall' "
. "  , AVG(IFNULL(crossed_rough_terrain,0)) as 'avg_cross_rough' "

. "  , AVG(IFNULL(pick_boulder,0)) as 'avg_pick_boulder' "
. "  , AVG(IFNULL(pass_boulder,0)) as 'avg_pass_boulder' " 
. "  , AVG(IFNULL(score_low,0)) as 'avg_score_low' "
. "  , AVG(IFNULL(score_high,0)) as 'avg_score_high' "
. "  , AVG(IFNULL(get_on_tower,0)) as 'avg_get_on_tower' " 
. "  , AVG(IFNULL(climb_tower,0)) as 'avg_climb_tower' "
. "  , AVG(IFNULL(defense,0)) as 'avg_defense' "
. "  , AVG(IFNULL(fouls,0)) as 'avg_fouls' " 
. "  , AVG(IFNULL(died,0)) as 'avg_deaths' " 
. "  , MAX(IFNULL(score_low,0)) as 'max_score_low' "
. "  , MAX(IFNULL(score_high,0)) as 'max_score_high' "
. "FROM team "
. "  LEFT JOIN stat "
. "    ON stat.team_id = team.id "
. "  LEFT JOIN flat_stat "
. "    ON stat.id = flat_stat.id ";

if ($single_team) {
  $query = $query . "WHERE team_id = $team_id ";
} else {
    $query = $query . "GROUP BY team_id ";
}

$result = mysql_query($query);
//echo "<p>$query</p>"; //debug

if (!$result) die("Database query failed: " . mysql_error());

if ($single_team) {
    echo_single_team($result, $team_id);
} else {
    echo_all_teams($result);
}

function echo_single_team($sql_result, $team_number) {

echo '<div class="panel panel-default">Scouting report for team ' . $team_number;
echo '</div>';

echo '<table class="table table-striped"><tbody>';
echo "<tr><td>Scouted matches</td><td>";
echo mysql_result($sql_result, 0, 'scouted_matches');
echo "</td></tr><tr><td>Reach Defense in Auto</td><td>";
echo mysql_result($sql_result, 0, 'avg_auto_reach_defense');
echo "</td></tr><tr><td>Cross Defense in Auto</td><td>";
echo mysql_result($sql_result, 0, 'avg_auto_cross_defense');
echo "</td></tr><tr><td>Low Goal in Auto</td><td>";
echo mysql_result($sql_result, 0, 'avg_auto_low_goal');
echo "</td></tr><tr><td>High Goal in Auto</td><td>";
echo mysql_result($sql_result, 0, 'avg_auto_high_goal');

echo "</td></tr><tr><td>Cross Low Bar</td><td>";
echo mysql_result($sql_result, 0, 'avg_cross_low_bar');
echo "</td></tr><tr><td>Cross Portcullis</td><td>";
echo mysql_result($sql_result, 0, 'avg_cross_portcullis');
echo "</td></tr><tr><td>Cross Cheval De Frise</td><td>";
echo mysql_result($sql_result, 0, 'avg_cross_cheval');
echo "</td></tr><tr><td>Cross Ramparts</td><td>";
echo mysql_result($sql_result, 0, 'avg_cross_ramparts');
echo "</td></tr><tr><td>Cross Moat</td><td>";
echo mysql_result($sql_result, 0, 'avg_cross_moat');
echo "</td></tr><tr><td>Cross SallyPort</td><td>";
echo mysql_result($sql_result, 0, 'avg_cross_sallyport');
echo "</td></tr><tr><td>Cross Drawbridge</td><td>";
echo mysql_result($sql_result, 0, 'avg_cross_drawbridge');
echo "</td></tr><tr><td>Cross Rock Wall</td><td>";
echo mysql_result($sql_result, 0, 'avg_cross_rockwall');
echo "</td></tr><tr><td>Cross Rough Terrain</td><td>";
echo mysql_result($sql_result, 0, 'avg_cross_rough');

echo "</td></tr><tr><td>Pick Ball</td><td>";
echo mysql_result($sql_result, 0, 'avg_pick_boulder');
echo "</td></tr><tr><td>Pass Ball</td><td>";
echo mysql_result($sql_result, 0, 'avg_pass_boulder'); 
echo "</td></tr><tr><td>Score Low</td><td>";
echo mysql_result($sql_result, 0, 'avg_score_low');
echo "</td></tr><tr><td>Score High</td><td>";
echo mysql_result($sql_result, 0, 'avg_score_high');
echo "</td></tr><tr><td>Get on tower platform at end</td><td>";
echo mysql_result($sql_result, 0, 'avg_get_on_tower');
echo "</td></tr><tr><td>Climb tower</td><td>";
echo mysql_result($sql_result, 0, 'avg_climb_tower');
echo "</td></tr><tr><td>Defense moves</td><td>";
echo mysql_result($sql_result, 0, 'avg_defense');
echo "</td></tr><tr><td>Fouls</td><td>";
echo mysql_result($sql_result, 0, 'avg_fouls');
echo "</td></tr><tr><td>Deaths</td><td>";
echo mysql_result($sql_result, 0, 'avg_deaths');
echo "</td></tr><tr><td>Max Low Goal</td><td>";
echo mysql_result($sql_result, 0, 'max_score_low');
echo "</td></tr><tr><td>Max High Goal</td><td>";
echo mysql_result($sql_result, 0, 'max_score_high');
echo "</td></tr></tbody></table>";
}

function echo_all_teams($sql_result) {

  echo '<table class="table table-striped">';
  echo '<thead><tr><th>Team</th><th>Scouted Matches</th>';
  echo '<th>Auto Reach Defense</th><th>Auto Cross Defense</th>';
  echo '<th>Auto Low Goal</th><th>Auto High Goal</th>';
  
  echo '<th>Cross Low Bar</th>';
  echo "<th>Cross Portcullis</th><th>Cross Cheval De Frise</th>";
  echo "<th>Cross Ramparts</th><th>Cross Moat</th>";
  echo "<th>Cross SallyPort</th><th>Cross Drawbridge</th>";
  echo "<th>Cross Rock Wall</th><th>Cross Rough Terrain</th>";

  echo '<th>Pick Ball</th><th>Pass Ball</th>';
  echo '<th>Score Low</th><th>Score High</th>';
  echo '<th>Reach Twr</th><th>Climb Twr</th>';
  echo '<th>Defense</th><th>Fouls</th>';
  echo '<th>Died</th>';
  echo '<th>Max Low Goal</th><th>Max High Goal</th>';

  echo '</tr><tbody>';
  while ($row = mysql_fetch_assoc($sql_result)) {
    echo '<tr>';
    echo '<td>' . $row["team"] . '</td>';
    echo '<td>' . $row["scouted_matches"] .'</td>';
    echo '<td>' . $row["avg_auto_reach_defense"] . '</td>';
    echo '<td>' . $row["avg_auto_cross_defense"] . '</td>';
    echo '<td>' . $row["avg_auto_low_goal"] . '</td>';
    echo '<td>' . $row["avg_auto_high_goal"] .'</td>';
    
    echo '<td>' . $row["avg_cross_low_bar"] . '</td>';
    echo '<td>' . $row["avg_cross_portcullis"] . '</td>';
    echo '<td>' . $row["avg_cross_cheval"] . '</td>';
    echo '<td>' . $row["avg_cross_ramparts"] . '</td>';
    echo '<td>' . $row["avg_cross_moat"] . '</td>';
    echo '<td>' . $row["avg_cross_sallyport"] . '</td>';
    echo '<td>' . $row["avg_cross_drawbridge"] . '</td>';
    echo '<td>' . $row["avg_cross_rockwall"] . '</td>';
    echo '<td>' . $row["avg_cross_rough"] . '</td>';

    echo '<td>' . $row["avg_pick_boulder"] . '</td>';
    echo '<td>' . $row["avg_pass_boulder"] . '</td>';
    echo '<td>' . $row["avg_score_low"] . '</td>';
    echo '<td>' . $row["avg_score_high"] . '</td>';
    echo '<td>' . $row["avg_get_on_tower"] . '</td>';
    echo '<td>' . $row["avg_climb_tower"] . '</td>';
    echo '<td>' . $row["avg_defense"] . '</td>';
    echo '<td>' . $row["avg_fouls"] . '</td>';
    echo '<td>' . $row["avg_deaths"] . '</td>';
    echo '<td>' . $row["max_score_low"] . '</td>';
    echo '<td>' . $row["max_score_high"] . '</td>';
    echo '</tr>';
  }
  echo "</td></tr></tbody></table>";
}

?>
    <script src="lib/js/jquery-1.10.1.js"></script>
    <script src="lib/js/bootstrap.min.js"></script>
  </body>
</html>

