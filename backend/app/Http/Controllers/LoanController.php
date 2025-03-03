<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowedBook;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{

    public function borrow(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id'
        ]);

        $user_id = $request->input('user_id');
        $book_id = $request->input('book_id');

        $existingLoan = BorrowedBook::where('user_id', $user_id)
            ->where('book_id', $book_id)
            ->whereIn('status', ['borrowed', 'requested_return'])
            ->exists();

        if ($existingLoan) {
            return response()->json([
                'message' => 'You have already borrowed this book and have not returned it yet.'
            ], 400);
        }

        $book = Book::findOrFail($book_id);

        if ($book->bookType->copies <= 0) {
            return response()->json(['message' => 'No available copies of this book'], 400);
        }

        $loan = BorrowedBook::create([
            'user_id' => $user_id,
            'book_id' => $book->id,
            'status' => 'borrowed'
        ]);

        $book->bookType->decrement('copies');

        return response()->json([
            'message' => 'Book successfully borrowed',
            'loan' => $loan
        ]);
    }

    public function requestReturn(Request $request, $loan_id)
    {
        $user = Auth::user();

        $loan = BorrowedBook::find($loan_id);

        if (!$loan) {
            return response()->json(['message' => 'Loan not found'], 404);
        }

        if ($loan->user_id !== $user->id) {
            return response()->json(['message' => 'You cannot return a book on behalf of someone else'], 403);
        }

        if ($loan->status !== 'borrowed') {
            return response()->json(['message' => 'This book has already been requested for return or returned'], 400);
        }

        $loan->update(['status' => 'requested_return']);

        return response()->json([
            'message' => 'Return request submitted successfully',
            'loan' => $loan
        ]);
    }
    public function returnBook(Request $request, $loan_id)
    {
        $user = Auth::user();

        $loan = BorrowedBook::find($loan_id);

        if (!$loan) {
            return response()->json(['message' => 'Loan not found'], 404);
        }

        if ($loan->user_id !== $user->id) {
            return response()->json(['message' => 'You cannot return a book on behalf of someone else'], 403);
        }

        if ($loan->status !== 'borrowed' && $loan->status !== 'requested_return') {
            return response()->json(['message' => 'This book has already been returned'], 400);
        }

        $book = Book::find($loan->book_id);
        if ($book) {
            $book->bookType->increment('copies');
        }

        $loan->delete();

        return response()->json([
            'message' => 'Book returned successfully'
        ]);
    }

}
