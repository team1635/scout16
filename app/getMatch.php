<?php

/*
 * Copyright (c) 2015 FRC Team 1635
 */
 
require_once 'infodb.php';

$db_server = mysql_connect($db_hostname, $db_username , $db_password);

if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());

$query = "SELECT m.id, m.event_id, e.name "
         . "  , e.code, m.type_, m.number_ "
         . "  , m.red_team1_id, m.red_team2_id, m.red_team3_id "
         . "  , blue_team1_id, blue_team2_id, blue_team3_id "
         . "  , red_def2, red_def3, red_def4, red_def5 "
         . "  , blue_def2, blue_def3, blue_def4, blue_def5 "
         . "FROM match_ m "
         . "  JOIN current_ c "
         . "    ON  m.number_ = c.match_number "
         . "      AND m.type_ = c.match_type "
         . "  JOIN event e "
         . "    ON c.event_code = e.code "
         . "      AND e.id = m.event_id "; 

$result = mysql_query($query);

//echo "<p>$query</p>"; //debug
if (!$result) die("Database access failed: " . mysql_error());

//TODO: check that we get one row and only one row
//TODO : how do I return the error to the front-end?  
//  Right now I get an unexpected identifier just after deploying
//  with no rows in the table 
//TODO: should figure out how the first match gets inserted
$match = array(
  'id' => mysql_result($result, 0, 'id')
  , 'event_id' => mysql_result($result, 0, 'event_id')
  , 'event_name' => mysql_result($result, 0, 'name')
  , 'event_code' => mysql_result($result, 0, 'code')
  , 'match_type' => mysql_result($result, 0, 'type_')
  , 'number_' => mysql_result($result, 0, 'number_')
  , 'red_team1_id' => mysql_result($result, 0, 'red_team1_id')
  , 'red_team2_id' => mysql_result($result, 0, 'red_team2_id')
  , 'red_team3_id' => mysql_result($result, 0, 'red_team3_id')
  , 'blue_team1_id' => mysql_result($result, 0, 'blue_team1_id')
  , 'blue_team2_id' => mysql_result($result, 0, 'blue_team2_id')
  , 'blue_team3_id' => mysql_result($result, 0, 'blue_team3_id')
  , 'red_def2' => mysql_result($result, 0, 'red_def2')
  , 'red_def3' => mysql_result($result, 0, 'red_def3')
  , 'red_def4' => mysql_result($result, 0, 'red_def4')
  , 'red_def5' => mysql_result($result, 0, 'red_def5')
  , 'blue_def2' => mysql_result($result, 0, 'blue_def2')
  , 'blue_def3' => mysql_result($result, 0, 'blue_def3')
  , 'blue_def4' => mysql_result($result, 0, 'blue_def4')
  , 'blue_def5' => mysql_result($result, 0, 'blue_def5')
);

echo json_encode($match); 
?>