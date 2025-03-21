<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookType;
use Illuminate\Support\Facades\Log;
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
            return response()->json(['message' => __('messages.book_not_found')], 404);
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

        Log::info('Book Created:', $book->toArray());

        $this->updateTotalQuantity();

        return response()->json([
            'message' => __('messages.book_added'),
            'book' => $book
        ], 201);
    }

    public function update(Request $request, Book $book)
    {
        if (!$book) {
            return response()->json(['message' => __('messages.book_not_found')], 404);
        }

        $request->validate([
            'inventory_number' => 'sometimes|string|unique:books,inventory_number,' . $book->id
        ]);

        $book->update($request->all());

        $this->updateTotalQuantity();

        return response()->json([
            'message' => __('messages.book_updated'),
            'book' => $book
        ]);
    }

    public function destroy(Book $book)
    {
        if (!$book) {
            return response()->json(['message' => __('messages.book_not_found')], 404);
        }

        $book->delete();

        $this->updateTotalQuantity();

        return response()->json(['message' => __('messages.book_deleted')]);
    }

    private function updateTotalQuantity()
    {
        DB::statement("UPDATE book_types bt SET bt.copies = (
            SELECT COUNT(*) FROM books b WHERE b.book_type_id = bt.id
        )");
    }
}
