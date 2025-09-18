<?php
//Set Timezone
date_default_timezone_set("Africa/Maputo");
//Database credentials
$dbHost     = 'localhost';
$dbUsername = 'root';
$dbPassword = 'icor3000%%';
$dbName     = 'reuniao_cardio';

//Connect and select the database
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
mysqli_set_charset($db,"utf8");
?>
