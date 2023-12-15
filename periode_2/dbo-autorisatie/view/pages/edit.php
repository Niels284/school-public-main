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
$session_user = $db->getUser($_SESSION['user']['id']);

if (isset($_GET['id'])) {
    $user = $db->getUser(htmlspecialchars($_GET['id']));
}

if (isset($_POST['update_gebruiker'])) {
    $message = $db->updateUser(
        htmlspecialchars($_GET['id']),
        htmlspecialchars($_POST['gebruikersnaam']),
        htmlspecialchars($_POST['wachtwoord']),
        htmlspecialchars($_POST['rechten_niveau'])
    );
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
    <h1>Bewerk gebruiker <?= $user['gebruikersnaam'] ?></h1>
    <form method="post">
        <div class="form-group">
            <label for="gebruikersnaam">Gebruikersnaam</label>
            <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam" value="<?= $user['gebruikersnaam'] ?>">
        </div>
        <div class="form-group">
            <label for="wachtwoord">Wachtwoord</label>
            <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
        </div>
        <?php if ($user['rechten_niveau'] <= $session_user['rechten_niveau']) : ?>
            <div class="form-group">
                <label for="rechten_niveau">Rechten niveau</label>
                <select name="rechten_niveau">
                    <option value="0" <?= $user['rechten_niveau'] === 0 ? 'selected' : '' ?>>0</option>
                    <option value="1" <?= $user['rechten_niveau'] === 1 ? 'selected' : '' ?>>1</option>
                    <?php if ($session_user['rechten_niveau'] >= 3) : ?>
                        <option value="2" <?= $user['rechten_niveau'] === 2 ? 'selected' : '' ?>>2</option>
                    <?php endif; ?>
                    <?php if ($session_user['rechten_niveau'] >= 4) : ?>
                        <option value="3" <?= $user['rechten_niveau'] === 3 ? 'selected' : '' ?>>3</option>
                        <option value="4" <?= $user['rechten_niveau'] === 4 ? 'selected' : '' ?>>4</option>
                    <?php endif; ?>
                </select>
            </div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary" name="update_gebruiker">Wijzigingen opslaan</button>
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