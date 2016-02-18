<?php
/*
 * Copyright (c) 2015 FRC Team 1635
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have receiveh a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
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
);

echo json_encode($match); 

?>
