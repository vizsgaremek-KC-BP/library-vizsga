<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookType;
use Illuminate\Support\Facades\File;

class ImportBookTypes extends Command
{
    protected $signature = 'import:booktypes';
    protected $description = 'Import book types from a JSON file';

    public function handle()
    {
        $filePath = storage_path('app/book.json');

        if (!File::exists($filePath)) {
            $this->error('The book.json file does not exist.');
            return;
        }

        $jsonData = File::get($filePath);
        $books = json_decode($jsonData, true);

        if (!$books) {
            $this->error('Invalid JSON format.');
            return;
        }

        foreach ($books as $book) {
            BookType::updateOrCreate(
                ['title' => $book[1]],
                [
                    'author' => $book[2],
                    'price' => $book[3],
                    'copies' => $book[4],
                ]
            );
        }

        $this->info('Book types imported successfully!');
    }
}
