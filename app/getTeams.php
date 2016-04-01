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

$db_server = mysql_connect($db_hostname, $db_username , $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());

$query = "SELECT "
. "  team.id as 'team'"
. "  , CASE "
. "      WHEN stat.team_id IS NULL THEN 0 "
. "      ELSE COUNT(*) "
. "     END as 'scouted_matches' " 
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
. "    ON stat.id = flat_stat.id "
. "GROUP BY team.id ";

$result = mysql_query($query);
//echo "<p>$query</p>"; //debug

if (!$result) die("Database query failed: " . mysql_error());

echo_all_teams($result);


function echo_all_teams($sql_result) {

  echo '<table class="table table-striped">';
  echo '<thead><tr><th>Team</th><th>Scouted Matches</th>';
  echo '<th>Auto Reach Defense</th><th>Auto Cross Defense</th>';
  echo '<th>Auto Low Goal</th><th>Auto High Goal</th>';
  
  echo '<th>Cross Low Bar</th><th>Cross Portcullis</th>';
  echo '<th>Cross Cheval</th><th>Cross Ramparts</th>';
  echo '<th>Cross Moat</th><th>Cross Sally Port</th>';
  echo '<th>Cross Drawbridge</th><th>Cross Rock Wall</th>';
  echo '<th>Cross Rough Terrain</th>';
  
  echo '<th>Pick Ball</th><th>Pass Ball</th>';
  echo '<th>Score Low</th><th>Score High</th>';
  echo '<th>Reach Twr</th><th>Climb Twr</th>';
  echo '<th>Defense</th><th>Fouls</th>';
  echo '<th>Died</th><th>Max Low Goal</th>';
  echo '<th>Max High Goal</th>';

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

