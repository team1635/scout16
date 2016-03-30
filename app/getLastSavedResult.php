<?php

require_once 'infodb.php';

$db_server = mysql_connect($db_hostname, $db_username , $db_password);

if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());

$query = "SELECT e.id, c.match_type, c.last_saved_result "
         . "FROM current_ c "
         . "  JOIN event e "
         . "    ON c.event_code = e.code ";

$result = mysql_query($query);

//echo "<p>$query</p>"; //debug
if (!$result) die("Cannot retrieve last saved match: " . mysql_error());

//TODO: check that we get one row and only one row
//TODO : how do I return the error to the front-end?  
//  Right now I get an unexpected identifier just after deploying
//  with no rows in the table 
//TODO: should figure out how the first match gets inserted
$last_saved_result_arr = array(
  'event_id' => mysql_result($result, 0, 'id')
  , 'match_type' => mysql_result($result, 0, 'match_type')
  , 'last_saved_result' => mysql_result($result, 0, 'last_saved_result')
);

echo json_encode($last_saved_result_arr);  
?>