<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$emails = json_decode(file_get_contents('./email.json'))->emails;
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XML-JSON - Assignment</title>
</head>

<body>
    <table>
        <tr>
            <th>Persoon</th>
            <th>Aan</th>
            <th>Onderwerp</th>
        </tr>
        <?php
        foreach ($emails as $email) {
            echo "<tr>";
            echo "<td>" . $email->naam . "</td>";
            echo "<td>" . $email->verzendenAan . "</td>";
            echo "<td>" . $email->onderwerp . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>