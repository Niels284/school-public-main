<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// (object) ["key"=>"value"] maakt een object van het array: $klas->key = value.
$klas = (object) [
    "studenten" =>
    [
        (object) ["naam" => "Johan", "plaats" => "Tilburg"],
        (object) ["naam" => "Michel", "plaats" => "Tilburg"],
        (object) ["naam" => "Bart", "plaats" => "Goirle"],
        (object) ["naam" => "Anneloes", "plaats" => "Tilburg"],
        (object) ["naam" => "Marlies", "plaats" => "Oisterwijk"]
    ]
];

foreach ($klas->studenten as $student) {
    if ($student->plaats !== "Tilburg") {
        unset($student);
    } else {
        $studentsFromTilburg[] = $student;
    }
}
// echo json_encode($klas, JSON_PRETTY_PRINT); // Levert een JSON-string op
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XML-JSON - Assignment</title>
</head>

<body>
    <p>Studenten die in Tilburg wonen:</p>
    <ul>
        <?php foreach ($studentsFromTilburg as $student) : ?>
            <li><?= $student->naam ?></li>
        <?php endforeach; ?>
    </ul>
</body>

</html>