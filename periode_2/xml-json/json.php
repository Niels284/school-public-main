<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header('Access-Control-Allow-Origin: *'); // CORS (=requests alle (*) domeinen toestaan)
header('Content-Type: application/json'); // JSON header, dient om de browser te vertellen dat de response JSON is

var_dump(json_decode(file_get_contents('./email.json')));
