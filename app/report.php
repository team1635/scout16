<html>
  <head>
    <title>1635 matches</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content=width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="lib/css/bootstrap.min.css" />
    <link rel="stylesheet" href="lib/css/main.css" />
  </head>
  <body>
<table class="table table-striped">
  <thead>
      <th>Match</th>
      <th>Red 1</th>
      <th>Red 2</th>
      <th>Red 3</th>
      <th>Blue 1</th>
      <th>Blue 2</th>
      <th>Blue 3</th>
  </thead>
  <tbody>
<?php
require_once 'infodb.php';

$db_server = mysql_connect($db_hostname, $db_username , $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());

$our_team = 1635; //TODO: take a parameter
$query = "SELECT number_ as match_number"
  . " , red_team1_id, red_team2_id, red_team3_id "
  . " , blue_team1_id, blue_team2_id, blue_team3_id "
  . " FROM match_ m "
  . " JOIN event e "
  . "   ON m.event_id = e.id "
  . " JOIN current_ c "
  . "   ON e.code = c.event_code "
  . "    AND m.type_ = c.match_type "
  . " WHERE m.red_team1_id = " . $our_team
  . "   OR m.red_team2_id =  " . $our_team
  . "   OR m.red_team3_id =  " . $our_team
  . "   OR m.blue_team1_id =  " . $our_team
  . "   OR m.blue_team2_id =  " . $our_team
  . "   OR m.blue_team3_id =  " . $our_team
  . " ORDER BY m.number_ ";

$result = mysql_query($query);
//echo "<p>$query</p>"; //debug

if (!$result) die("Database query failed: " . mysql_error());

while ($row = mysql_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row["match_number"] . '</td>';
    echo '<td><a href="getTeamReport.php?team_id=' . $row["red_team1_id"] . '">' . $row["red_team1_id"] . '</a></td>';
    echo '<td><a href="getTeamReport.php?team_id=' . $row["red_team2_id"] . '">' . $row["red_team2_id"] . '</a></td>';
    echo '<td><a href="getTeamReport.php?team_id=' . $row["red_team3_id"] . '">' . $row["red_team3_id"] . '</a></td>';
    echo '<td><a href="getTeamReport.php?team_id=' . $row["blue_team1_id"] . '">' . $row["blue_team1_id"] . '</a></td>';
    echo '<td><a href="getTeamReport.php?team_id=' . $row["blue_team2_id"] . '">' . $row["blue_team2_id"] . '</a></td>';
    echo '<td><a href="getTeamReport.php?team_id=' . $row["blue_team3_id"] . '">' . $row["blue_team3_id"] . '</a></td>';
    echo '</tr>';
}

?> 
  </tbody>
</table>

    <script src="lib/js/jquery-1.10.1.js"></script>
    <script src="lib/js/bootstrap.min.js"></script>
  </body>
</html>
