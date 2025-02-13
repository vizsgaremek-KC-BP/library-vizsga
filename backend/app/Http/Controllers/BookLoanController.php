<?php

namespace App\Http\Controllers;

use App\Models\BookLoan;
use Illuminate\Http\Request;

class BookLoanController extends Controller
{
    public function borrowBook(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $loan = BookLoan::create([
            'user_id' => $validated['user_id'],
            'book_id' => $validated['book_id'],
            'borrowed_at' => now(),
        ]);

        return response()->json($loan, 201);
    }

    public function returnBook(Request $request, $loan_id)
    {
        $loan = BookLoan::findOrFail($loan_id);

        if ($loan->is_returned) {
            return response()->json(['message' => 'Book already returned.'], 400);
        }

        $loan->returned_at = now();
        $loan->is_returned = true;
        $loan->save();

        return response()->json($loan, 200);
    }

    public function getUserLoans($user_id)
    {
        $loans = BookLoan::where('user_id', $user_id)->with('book')->get();

        return response()->json($loans, 200);
    }
}