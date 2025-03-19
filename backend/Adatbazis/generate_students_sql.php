<?php

$studentsCsvPath = __DIR__ . "/students.csv";

if (!file_exists($studentsCsvPath)) {
    die("Hiba: A students.csv fájl nem található!\n");
}

$csvFile = fopen($studentsCsvPath, "r");
if (!$csvFile) {
    die("Hiba: Nem sikerült beolvasni a students.csv fájlt!\n");
}

fgetcsv($csvFile);

$sql = "INSERT INTO students (name, edu_id, status) VALUES \n";

while (($row = fgetcsv($csvFile)) !== false) {
    [$name, $eduId] = $row;
    $sql .= "('$name', '$eduId', 'active'),\n";
}

fclose($csvFile);

$sql = rtrim($sql, ",\n") . ";";

$outputFile = __DIR__ . "/insert_students.sql";
file_put_contents($outputFile, $sql);

echo "SQL beszúrások legenerálva! Nézd meg az insert_students.sql fájlt.\n";

// Ezt futtasd
// php generate_students_sql.php