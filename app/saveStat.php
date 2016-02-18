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

(isset($_POST['team_id']) && isset($_POST['match__id'])) or
  die("<p>Need at least a team number and a match number.</p>");


$team_id = SanitizeString($_POST['team_id']);
$match__id = SanitizeString($_POST['match__id']);

$auto_robot = SanitizeString($_POST['auto_robot']);
$auto_tote = SanitizeString($_POST['auto_tote']);
$auto_can = SanitizeString($_POST['auto_can']);
$auto_stack = SanitizeString($_POST['auto_stack']);
$auto_position = SanitizeString($_POST['auto_position']);

$scored_gray = SanitizeString($_POST['scored_gray']);
$scored_can_level = SanitizeString($_POST['scored_can_level']);
$score_stack = SanitizeString($_POST['score_stack']);
$carry_stack = SanitizeString($_POST['carry_stack']);
$handle_litter = SanitizeString($_POST['handle_litter']);
$fallen_can = SanitizeString($_POST['fallen_can']);
$noodle_in_can = SanitizeString($_POST['noodle_in_can']);
$clear_recycle = SanitizeString($_POST['clr_rec_area']); //exception
$grab_step_can = SanitizeString($_POST['grab_step_can']);

$coop = SanitizeString($_POST['coop']);
$coop_stack = SanitizeString($_POST['coop_stack']);

$fouls = SanitizeString($_POST['fouls']);

$db_server = mysql_connect($db_hostname, $db_username , $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
  die("Unable to select database: " . mysql_error());

$query = "INSERT stat (team_id, match__id, auto_robot "
         . "  , auto_tote, auto_can, auto_stack "
         . "  , auto_position, scored_gray, scored_can_level "
         . "  , score_stack, carry_stack, handle_litter "
         . "  , fallen_can, noodle_in_can, clear_recycle "
         . "  , grab_step_can, coop, coop_stack "
         . "  , fouls ) "
         . "VALUES ($team_id, '$match__id', $auto_robot "
         . "  , $auto_tote, $auto_can, $auto_stack "
         . "  , $auto_position, $scored_gray, $scored_can_level "
         . "  , $score_stack, $carry_stack, $handle_litter "
         . "  , $fallen_can, $noodle_in_can, $clear_recycle "
         . "  , $grab_step_can, $coop, $coop_stack "
         . "  , $fouls ) ";

$result = mysql_query($query);
//echo "<p>$query</p>"; //debug
if (!$result) die("Database access failed: " . mysql_error());

echo "<p>Team $team_id stats for match id $match__id saved.</p>"; 

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
