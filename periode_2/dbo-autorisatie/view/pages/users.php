<?php

session_start();

use Controllers\Controller1;

include_once('../../controller/controller.php');

$message;

if (isset($_SESSION['message']['success'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
} else if (isset($_SESSION['message']['error'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if (!isset($_SESSION['user']['id'])) {
    header('Location: ./login.php');
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['user']);
    $_SESSION['message'] = ['success' => 'U bent succesvol uitgelogd'];
    header('Location: ./login.php');
    exit;
}

$db = new Controller1();
$users = $db->getUsers();
$session_user = $db->getUser($_SESSION['user']['id']);

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
    <h1>Gebruikers</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>gebruikersnaam</th>
                <th>rechten niveau</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['gebruikersnaam'] ?></td>
                    <td><?= $user['rechten_niveau'] ?></td>
                    <td>
                        <?php if ($user['id'] !== $session_user['id']) : ?>
                            <?php if ($session_user['rechten_niveau'] >= 3) : ?>
                                <a href="./edit.php?id=<?= $user['id'] ?>">Bewerken</a>
                            <?php endif; ?>
                            <?php if ($session_user['rechten_niveau'] >= 4) : ?>
                                <a href="./delete.php?id=<?= $user['id'] ?>">Verwijderen</a>
                            <?php endif; ?>
                        <?php else : ?>
                            <p>Je kan jezelf niet bewerken 😂</p>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($session_user['rechten_niveau'] >= 2) : ?>
        <a href="./register.php">Gebruiker toevoegen</a>
    <?php endif; ?>
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
    <a href="?action=logout">Uitloggen</a>
</body>

</html>