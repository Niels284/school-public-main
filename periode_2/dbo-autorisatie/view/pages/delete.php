<?php

session_start();

use Controllers\Controller1;

include_once('../../controller/controller.php');

$message;

if (!isset($_SESSION['user']['id'])) {
    header('Location: ./login.php');
    exit;
}

$db = new Controller1();

if (isset($_GET['id'])) {
    $_SESSION['message'] = $db->deleteUser(htmlspecialchars($_GET['id']));
    header('Location: ./users.php');
}
