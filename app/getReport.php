<?php

require_once 'infodb.php';

$post_data = file_get_contents("php://input"); //debug

isset($_POST['match_nr']) or
  die("<p>Need match number. Got $post_data</p>");

$match_nr = SanitizeString($_POST['match_nr']);

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
         . "    ON m.type_ = c.match_type "
         . "  JOIN event e "
         . "    ON c.event_code = e.code "
         . "      AND e.id = m.event_id " 
         . "WHERE m.number_ = $match_nr";


$result = mysql_query($query);
//echo "<p>$query</p>"; //debug
if (!$result) die("Database access failed: " . mysql_error());

//TODO: check that we get one row and only one row
$match = array(
  'red_team1_id' => mysql_result($result, 0, 'red_team1_id')
  , 'red_team2_id' => mysql_result($result, 0, 'red_team2_id')
  , 'red_team3_id' => mysql_result($result, 0, 'red_team3_id')
  , 'blue_team1_id' => mysql_result($result, 0, 'blue_team1_id')
  , 'blue_team2_id' => mysql_result($result, 0, 'blue_team2_id')
  , 'blue_team3_id' => mysql_result($result, 0, 'blue_team3_id')
);

echo json_encode($match); 

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
