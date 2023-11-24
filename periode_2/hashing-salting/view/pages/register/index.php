<?php
session_start();

include_once '../../../model/database.php';
include_once '../../../controller/functions.php';

use Controller\Database;

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', 1);

$database = new Database();

$message;
$usernameError;
$passwordError;

if (isset($_POST['create_account'])) {
    if (isset($_POST['username']) && isset($_POST['password1']) && isset($_POST['password2'])) {
        $username = is_valid_username(trim($_POST['username']));
        $password1 = is_valid_password(trim($_POST['password1']));
        $password2 = is_valid_password(trim($_POST['password2']));
        $_POST = array();
        if (!isset($message) && !isset($usernameError) && !isset($passwordError)) {
            if ($password1 !== $password2) {
                $message = ['error' => "Wachtwoorden komen niet overeen!"];
            } else {
                $salt = bin2hex(random_bytes(64));
                $hashedPassword = password_hash($password1 . $salt, PASSWORD_BCRYPT);
                $responseMessage = $database->createUser($username, $salt, $hashedPassword);
                if ($responseMessage['success']) {
                    $_SESSION['message'] = $responseMessage['success'];
                    header('Location:../login');
                }
            }
        }
    } else {
        $message = ['error' => "Vul alle velden in!"];
    }
}


?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../css/cssreset.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Hasing - Salting</title>
</head>

<body>
    <section class="vh-100 bg-image" style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Registreren</h2>
                                <form method="POST">
                                    <div class="form-outline mb-4">
                                        <input type="text" id="username" name="username" class="form-control form-control-lg" />
                                        <label class="form-label" for="username">Gebruikersnaam</label>
                                    </div>
                                    <?php
                                    if (isset($usernameError) && !empty($usernameError)) {
                                        echo "<div class='alert alert-danger' role='alert'>" . $usernameError['error'] . "</div>";
                                        $usernameError = "";
                                    }
                                    ?>
                                    <div class="form-outline mb-4">
                                        <input type="password" id="password1" name="password1" class="form-control form-control-lg" />
                                        <label class="form-label" for="password1">Nieuwe wachtwoord*</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="password" id="password2" name="password2" class="form-control form-control-lg" required />
                                        <label class="form-label" for="password2">Herhaal wachtwoord*</label>
                                    </div>
                                    <?php
                                    if (isset($passwordError) && !empty($passwordError)) {
                                        echo "<div class='alert alert-danger' role='alert'>" . $passwordError['error'] . "</div>";
                                        $passwordError = "";
                                    }
                                    ?>
                                    <p>* = Wachtwoord moet minstens 8 tekens lang zijn, met minstens één hoofdletter, één kleine letter en één cijfer!</p>
                                    <div class=" d-flex justify-content-center" style="margin-bottom:20px">
                                        <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" name="create_account">Maak account aan</button>
                                    </div>
                                    <?php
                                    if (isset($message) && !empty($message)) {
                                        if (!empty($message['error'])) {
                                            echo "<div class='alert alert-danger' role='alert'>" . $message['error'] . "</div>";
                                        } else {
                                            echo "<div class='alert alert-success' role='alert'>" . $message['success'] . "!</div>";
                                        }
                                        $message = "";
                                    }
                                    ?>
                                    <a href="../login">Ik heb al een account</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script type="module" src="../../js/script.js"></script>

</html>