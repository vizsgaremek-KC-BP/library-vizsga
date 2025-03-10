<?php

$booksJsonPath = __DIR__ . "/books.json";

if (!file_exists($booksJsonPath)) {
    die("Hiba: A books.json fájl nem található!\n");
}

$books = json_decode(file_get_contents($booksJsonPath), true);

if (!$books) {
    die("Hiba: Nem sikerült beolvasni a books.json fájlt!\n");
}

$sql = "INSERT INTO books (book_type_id, inventory_number) VALUES \n";

foreach ($books as $index => $book) {
    [$inventoryPrefix, $title, $author, $price, $copies] = $book;

    for ($i = 1; $i <= $copies; $i++) {
        $inventoryNumber = sprintf("%s-%03d", $inventoryPrefix, $i);
        $sql .= "(". ($index + 1) .",'$inventoryNumber'),\n";
    }
}

$sql = rtrim($sql, ",\n") . ";";

$outputFile = __DIR__ . "/insert_books.sql";
file_put_contents($outputFile, $sql);

echo "SQL beszúrások legenerálva! Nézd meg az insert_books.sql fájlt.\n";

//php Adatbazis/generate_sql.php

