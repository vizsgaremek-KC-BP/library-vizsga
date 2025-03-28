<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookType;
use League\Csv\Reader;
use Illuminate\Support\Facades\Storage;

class BookTypeSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = 'public/booktypes.csv';

        if (!Storage::exists($csvFile)) {
            echo "CSV fájl nem található: " . Storage::path($csvFile) . "\n";
            return;
        }

        $csvPath = Storage::path($csvFile);

        $csv = Reader::createFromPath($csvPath, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {

            $existingBookType = BookType::where('inventory_number_base', $record['inventory_number_base'])->first();

            if (!$existingBookType) {
                BookType::create([
                    'inventory_number_base' => $record['inventory_number_base'],
                    'title' => $record['title'],
                    'author' => $record['author'],
                    'price' => (int)$record['price'],
                    'copies' => (int)$record['copies'],
                ]);
            }
        }
    }
}
