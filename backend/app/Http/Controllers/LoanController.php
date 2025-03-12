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
            'user_edu_id' => 'required|exists:users,edu_id',
            'inventory_number' => 'required|exists:books,inventory_number'
        ]);

        $user_edu_id = $request->input('user_edu_id');
        $inventory_number = $request->input('inventory_number');

        $existingLoan = BorrowedBook::where('user_edu_id', $user_edu_id)
            ->where('inventory_number', $inventory_number) // itt inventory_number szerepel
            ->whereIn('status', ['borrowed', 'requested_return'])
            ->exists();

        if ($existingLoan) {
            return response()->json([
                'message' => 'You have already borrowed this book and have not returned it yet.'
            ], 400);
        }

        $book = Book::where('inventory_number', $inventory_number)->firstOrFail(); // itt inventory_number szerepel

        if ($book->bookType->copies <= 0) {
            return response()->json(['message' => 'No available copies of this book'], 400);
        }

        // Kölcsönzés rögzítése
        $loan = BorrowedBook::create([
            'user_edu_id' => $user_edu_id,
            'inventory_number' => $inventory_number, // Az inventory_number tárolása
            'status' => 'borrowed'
        ]);

        // Könyv példányok csökkentése
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

        if ((int) $loan->user_edu_id !== (int) $user->edu_id) {
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

        if ($loan->user_edu_id !== $user->edu_id) {
            return response()->json(['message' => 'You cannot return a book on behalf of someone else'], 403);
        }

        if ($loan->status !== 'borrowed' && $loan->status !== 'requested_return') {
            return response()->json(['message' => 'This book has already been returned'], 400);
        }

        if ($loan->status !== 'borrowed' && $loan->status !== 'requested_return') {
            return response()->json(['message' => 'This book has already been returned'], 400);
        }

        // A könyv keresése inventory_number alapján
        $book = Book::where('inventory_number', $loan->inventory_number)->first();

        if ($book) {
            $bookType = $book->bookType->increment('copies');
            $loan->update(['status' => 'returned']);
        }


        return response()->json([
            'message' => 'Book returned successfully'
        ]);
    }

    public function myLoans()
    {
        $user = Auth::user();
        $loans = BorrowedBook::where('user_edu_id', $user->edu_id)->with('book')->get();

        return response()->json([
            'loans' => $loans
        ]);
    }

}
