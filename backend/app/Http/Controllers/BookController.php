<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookType;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('bookType')->get();

        return response()->json($books);
    }

    public function show($id)
    {
        $book = Book::with('bookType')->find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json($book);
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:book_types,id',
            'inventory_number' => 'required|string|unique:books,inventory_number'
        ]);

        $book = Book::create($request->all());

        return response()->json([
            'message' => 'Book added successfully',
            'book' => $book
        ], 201);
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'inventory_number' => 'sometimes|string|unique:books,inventory_number,' . $book->id
        ]);

        $book->update($request->all());

        return response()->json([
            'message' => 'Book updated successfully',
            'book' => $book
        ]);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }
}
