<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

$mysqli = new mysqli('localhost', 'root', 'root', 'persons');
$zipcode = $mysqli->real_escape_string($_POST["zipcode"]);
$housenumber = $mysqli->real_escape_string($_POST["housenumber"]);
$sql = "SELECT address, city FROM city_test WHERE zipcode LIKE '" . $zipcode . "%' AND house_number LIKE '" . $housenumber . "%'";
$result = $mysqli->query($sql);
$ret = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($ret[0]);
