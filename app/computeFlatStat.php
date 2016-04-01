<?php

require_once 'infodb.php';

$db_server = mysql_connect($db_hostname, $db_username , $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());

$query = "TRUNCATE TABLE flat_stat";
$result = mysql_query($query);
//echo "<p>$query</p>"; //debug
if (!$result) die("Error truncating flat_stat: " . mysql_error());

$sql_script_red = "fix_def_red.sql";

$base_red_query = file_get_contents("fix_def_red.sql");

for ($i = 1; $i < 4; $i++) {
  $sql_script_file = "fix_def_red".$i.".sql";
  $query = $base_red_query . file_get_contents($sql_script_file);
  $result = mysql_query($query);
  //echo "<p>$query</p>"; //debug
  if (!$result) die("Error running sql script ($sql_script_file): " . mysql_error());
}

$base_blue_query = file_get_contents("fix_def_blue.sql");

for ($i = 1; $i < 4; $i++) {
  $sql_script_file = "fix_def_blue".$i.".sql";
  $query = $base_red_query . file_get_contents($sql_script_file);
  $result = mysql_query($query);
  //echo "<p>$query</p>"; //debug
  if (!$result) die("Error running sql script ($sql_script_file): " . mysql_error());
}

echo "<p>Recomputed flat_stat</p>\n"; 

?>