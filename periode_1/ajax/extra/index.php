<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./cssreset.css">
    <link rel="stylesheet" href="./style.css">
    <title>Project - Ajax</title>
</head>

<body>
    <main>
        <form method="post" action="./database.php">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Name" required>
            <label for="postcode">Postcode</label>
            <input type="text" name="postcode" id="postcode" placeholder="Postcode" required>
            <label for="huisnummer">Huisnummer</label>
            <input type="text" name="huisnummer" id="huisnummer" placeholder="Huisnummer" required>
            <label for="adres">Adres</label>
            <input type="text" name="adres" id="adres" placeholder="Adres" required>
            <label for="plaats">Plaats</label>
            <input type="text" name="plaats" id="plaats" placeholder="Plaats" required>
            <label for="telefoonnummer">Telefoonnummer</label>
            <input type="text" name="telefoonnummer" id="telefoonnummer" placeholder="Telefoonnummer" required>
            <button type="submit">Submit</button>
        </form>
    </main>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="module" src="./script.js"></script>

</html>