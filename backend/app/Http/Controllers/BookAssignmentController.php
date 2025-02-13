<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookAssignment;
use Illuminate\Http\Request;

class BookAssignmentController extends Controller
{
    public function assignBooks(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'class' => 'required|string',
            'quantity_assigned' => 'required|integer|min:1',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if ($book->quantity < $validated['quantity_assigned']) {
            return response()->json(['error' => 'Not enough books available'], 400);
        }

        $assignment = BookAssignment::create([
            'book_id' => $validated['book_id'],
            'class' => $validated['class'],
            'quantity_assigned' => $validated['quantity_assigned'],
        ]);

        $book->quantity -= $validated['quantity_assigned'];
        $book->save();

        return response()->json($assignment, 201);
    }
}
