<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    public function validateReturn(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $loans = BookLoan::where('user_id', $validated['user_id'])
                        ->where('is_returned', true)
                        ->with('book')
                        ->get();

        if ($loans->isEmpty()) {
            return response()->json(['message' => 'No books to validate for return.'], 400);
        }

        foreach ($loans as $loan) {
            $loan->validated_at = now();
            $loan->save();
        }

        return response()->json(['message' => 'Books validated successfully.', 'loans' => $loans], 200);
    }

    public function assignBook(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::find($validated['book_id']);
        if ($book->quantity <= 0) {
            return response()->json(['message' => 'The book is currently unavailable.'], 400);
        }

        $loan = BookLoan::create([
            'user_id' => $validated['user_id'],
            'book_id' => $validated['book_id'],
            'borrowed_at' => now(),
            'is_returned' => false,
        ]);

        $book->decrement('quantity');

        return response()->json(['message' => 'Book assigned successfully.', 'loan' => $loan], 201);
    }
}
