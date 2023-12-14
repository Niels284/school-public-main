<?php

session_start();

use Controllers\Controller1;

include_once('../../controller/controller.php');

$message;

if (isset($_SESSION['user']['id'])) {
    header('Location: ./users.php');
    exit;
}

if (isset($_SESSION['message']['success'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
} else if (isset($_SESSION['message']['error'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if (isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $db = new Controller1();
    $login = $db->login($username, $password);
    if (isset($login['error'])) {
        $message = $login;
    } else if (!isset($_SESSION['user'])) {
        $_SESSION['user']['id'] = $login['id'];
        $_SESSION['message'] = ['success' => 'U bent succesvol ingelogd'];
        header('Location: ./users.php');
    }
}

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cssreset.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>DBO - autorisatie</title>
</head>

<body>
    <form method="post">
        <label for="username">Gebruikersnaam</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Wachtwoord</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" name="login" value="Inloggen">
        <?php if (isset($message) && !empty($message['error'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $message['error'] ?>
            </div>
            <?php $message = [] ?>
        <?php elseif (!empty($message['success'])) : ?>
            <div class="alert alert-success" role="alert">
                <?= $message['success'] ?>
            </div>
            <?php $message = [] ?>
        <?php endif; ?>
    </form>
</body>

</html>