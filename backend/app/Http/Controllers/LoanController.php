<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowedBook;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            ->where('inventory_number', $inventory_number)
            ->whereIn('status', ['borrowed', 'requested_return'])
            ->exists();

        if ($existingLoan) {
            return response()->json([
                'message' => __('messages.book_already_borrowed')
            ], 400);
        }

        $book = Book::where('inventory_number', $inventory_number)->firstOrFail();

        if ($book->bookType->copies <= 0) {
            return response()->json(['message' => __('messages.no_available_copies')], 400);
        }

        DB::transaction(function () use ($user_edu_id, $inventory_number, $book) {
            BorrowedBook::create([
                'user_edu_id' => $user_edu_id,
                'inventory_number' => $inventory_number,
                'status' => 'borrowed'
            ]);

            $book->bookType->decrement('copies');
        });

        return response()->json(['message' => __('messages.book_borrowed_success')]);
    }

    public function requestReturn(Request $request)
    {
        $user = Auth::user();
        $loan_id = $request->input('loan_id');

        $loan = BorrowedBook::find($loan_id);

        if (!$loan) {
            return response()->json(['message' => __('messages.loan_not_found')], 404);
        }

        if ((int) $loan->user_edu_id !== (int) $user->edu_id) {
            return response()->json(['message' => __('messages.unauthorized_return')], 403);
        }

        if ($loan->status !== 'borrowed') {
            return response()->json(['message' => __('messages.return_request_error')], 400);
        }

        $loan->update(['status' => 'requested_return']);

        return response()->json(['message' => __('messages.return_request_submitted')]);
    }

    public function returnBook(Request $request)
    {
        $user = Auth::user();
        $loan_id = $request->input('loan_id');

        $loan = BorrowedBook::find($loan_id);

        if (!$loan) {
            return response()->json(['message' => __('messages.loan_not_found')], 404);
        }

        if ((int) $loan->user_edu_id !== (int) $user->edu_id) {
            return response()->json(['message' => __('messages.unauthorized_return')], 403);
        }

        if (!in_array($loan->status, ['borrowed', 'requested_return'])) {
            return response()->json(['message' => __('messages.return_request_error')], 400);
        }

        DB::transaction(function () use ($loan) {
            if ($loan->book && $loan->book->bookType) {
                $loan->book->bookType->increment('copies');
            }
            $loan->update(['status' => 'returned']);
        });

        return response()->json(['message' => __('messages.book_returned_success')]);
    }

    public function myLoans()
    {
        $user = Auth::user();
        $loans = BorrowedBook::where('user_edu_id', $user->edu_id)->with('book')->get();

        return response()->json(['loans' => $loans]);
    }
}
