<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use League\Csv\Reader;
use Illuminate\Support\Facades\Storage;

class BookSeeder extends Seeder
{
    public function run()
    {
        $csvFile = 'public/booktypes.csv';

        if (!Storage::exists($csvFile)) {
            $this->command->error("Hiba: A CSV fájl nem található!");
            return;
        }

        $csvPath = Storage::path($csvFile);
        $csv = Reader::createFromPath($csvPath, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            $id = $record['id'];
            $inventoryPrefix = $record['inventory_number_base'];
            $title = $record['title'];
            $author = $record['author'];
            $price = (int) $record['price'];
            $copies = (int) $record['copies'];

            for ($i = 1; $i <= $copies; $i++) {
                $inventoryNumber = sprintf("%s-%03d", $inventoryPrefix, $i);

                if (Book::where('inventory_number', $inventoryNumber)->exists()) {
                    continue;
                }

                Book::create([
                    'book_type_id' => $id,
                    'inventory_number' => $inventoryNumber
                ]);
            }
        }
    }
}
