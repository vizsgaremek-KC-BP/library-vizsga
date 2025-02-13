<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{

    public function getBook($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        return response()->json($book, 200);
    }

    public function getAllBooks()
    {
        $books = Book::all();

        return response()->json($books, 200);
    }

    public function addBook(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'is_return_required' => 'boolean',
        ]);

        $book = Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'quantity' => $validated['quantity'],
            'is_return_required' => $validated['is_return_required'] ?? false,
        ]);

        return response()->json($book, 201);
    }

    public function updateBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:1',
            'is_return_required' => 'nullable|boolean',
        ]);

        $book->update(array_filter($validated));

        return response()->json($book, 200);
    }

    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(null, 204);
    }
}