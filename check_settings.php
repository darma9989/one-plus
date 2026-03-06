<?php
define('BASEPATH', 'TRUE');
require_once('application/config/database.php');
$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

$res = $mysqli->query("SELECT * FROM settings");
while($row = $res->fetch_assoc()) {
    print_r($row);
}
$mysqli->close();
?>
