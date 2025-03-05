<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
        Log::info('Request Data:', $request->all());
    
        $request->validate([
            'book_type_id' => 'required|exists:book_types,id',
            'inventory_number' => 'required|string|unique:books,inventory_number'
        ]);
    
        $book = Book::create($request->all());
        
        $savedBook = Book::find($book->id);
        Log::info('Saved Book:', $savedBook ? $savedBook->toArray() : ['error' => 'Book not found']);
    
        $this->updateTotalQuantity();
    
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

        $this->updateTotalQuantity();

        return response()->json([
            'message' => 'Book updated successfully',
            'book' => $book
        ]);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        $this->updateTotalQuantity();

        return response()->json(['message' => 'Book deleted successfully']);
    }

    private function updateTotalQuantity()
    {
        DB::statement("UPDATE book_types bt SET bt.copies = (
            SELECT COUNT(*) FROM books b WHERE b.book_type_id = bt.id
        )");
    }
}
