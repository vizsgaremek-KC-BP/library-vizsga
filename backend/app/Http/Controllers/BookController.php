<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Könyv hozzáadása
    public function addBook(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer',
        ]);

        $book = Book::create($validated);

        return response()->json(['message' => 'Book added successfully', 'book' => $book], 201);
    }

    // Könyv lista lekérdezése
    public function getBooks()
    {
        $books = Book::all();
        return response()->json($books);
    }

    // Könyv státusz módosítása (pl. visszaszedendő)
    public function updateBookStatus($id, Request $request)
    {
        $book = Book::findOrFail($id);
        $book->status = $request->status;
        $book->save();

        return response()->json(['message' => 'Book status updated successfully']);
    }
}
