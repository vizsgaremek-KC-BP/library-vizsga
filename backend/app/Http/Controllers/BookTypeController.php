<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookType;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BookTypeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:book_types,title',
            'author' => 'required|string',
            'price' => 'required|numeric',
            'copies' => 'required|integer|min:0'
        ]);

        $bookType = BookType::create($request->all());

        $this->updateJsonFile($bookType);

        return response()->json([
            'message' => 'Book type added successfully',
            'book_type' => $bookType
        ], 201);
    }

    private function updateJsonFile(BookType $bookType)
{
    $filePath = storage_path('app/book.json');

    // Ha a fájl nem létezik, létrehozzuk
    if (!File::exists($filePath)) {
        File::put($filePath, json_encode([]));
    }

    // JSON betöltése
    $jsonData = File::get($filePath);
    $books = json_decode($jsonData, true) ?: [];

    // Ha régi tömbszerkezetű adatok vannak, átalakítjuk objektumokká
    $books = array_map(function ($book) {
        return is_array($book) && count($book) === 5
            ? [
                "id" => null,  // ID nincs a régi formátumban
                "title" => $book[1],
                "author" => $book[2],
                "price" => $book[3],
                "copies" => $book[4]
            ]
            : $book;
    }, $books);


    $books[] = [
        "id" => $bookType->id,
        "title" => $bookType->title,
        "author" => $bookType->author,
        "price" => $bookType->price,
        "copies" => $bookType->copies
    ];

    File::put($filePath, json_encode($books, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
}
