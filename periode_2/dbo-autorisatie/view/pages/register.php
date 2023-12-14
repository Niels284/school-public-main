<?php

session_start();

use Controllers\Controller1;

include_once('../../controller/controller.php');

$message;

if (!isset($_SESSION['user']['id'])) {
    header('Location: ./login.php');
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: ./login.php');
    exit;
}

$db = new Controller1();

if (isset($_GET['id'])) {
    $user = $db->getUser(htmlspecialchars($_GET['id']));
}

if (isset($_POST['create_gebruiker'])) {
    $update = $db->createUser(
        htmlspecialchars($_POST['gebruikersnaam']),
        htmlspecialchars($_POST['wachtwoord']),
        htmlspecialchars($_POST['rechten_niveau'])
    );
    if (isset($update['success'])) {
        $_SESSION['message'] = $update;
        header('Location: ./users.php');
        exit;
    } else {
        $message = $update;
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
    <h1>Maak hier een nieuwe gebruiker aan</h1>
    <form method="post">
        <div class="form-group">
            <label for="gebruikersnaam">Gebruikersnaam</label>
            <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam" placeholder="Gebruikersnaam">
        </div>
        <div class="form-group">
            <label for="wachtwoord">Wachtwoord</label>
            <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" placeholder="Wachtwoord">
        </div>
        <div class="form-group">
            <label for="rechten_niveau">Rechten niveau</label>
            <select name="rechten_niveau">
                <option value="0">0</option>
                <option value="1" selected>1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="create_gebruiker">Gebruiker aanmaken</button>
    </form>
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
    <a href="./users.php">Terug</a>
</body>

</html>