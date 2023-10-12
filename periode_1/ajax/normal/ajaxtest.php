<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

$mysqli = new mysqli('localhost', 'root', 'root', 'friends');
$letters = $mysqli->real_escape_string($_GET["data"]);
$sql = "SELECT name FROM friend WHERE name LIKE '" . $letters . "%'";
$result = $mysqli->query($sql);
$ret = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($ret);
