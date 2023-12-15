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

if (isset($_SESSION['user']['id'])) {
    $session_user = $db->getUser($_SESSION['user']['id']);
    if ($session_user['rechten_niveau'] < 4) {
        $_SESSION['message'] = ['error' => 'U heeft niet de juiste rechten om een gebruiker te verwijderen'];
        header('Location: ./users.php');
        exit;
    } else if (isset($_GET['id'])) {
        $_SESSION['message'] = $db->deleteUser(htmlspecialchars($_GET['id']));
        header('Location: ./users.php');
    }
} else {
    $_SESSION['message'] = ['error' => 'U moet ingelogd zijn om een gebruiker te verwijderen'];
    header('Location: ./login.php');
    exit;
}
