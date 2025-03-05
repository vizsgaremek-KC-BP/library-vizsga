<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowedBook;
use App\Models\Book;
use App\Models\BookType;

class AdminController extends Controller
{
    public function listLoans()
    {
        $loans = BorrowedBook::with(['user', 'book.bookType'])->get();

        return response()->json($loans);
    }

    public function approveReturn(BorrowedBook $loan)
    {
        if ($loan->status !== 'requested_return') {
            return response()->json(['message' => 'This loan is not pending return approval'], 400);
        }

        if ($loan->book && $loan->book->bookType) {
            $loan->book->bookType->increment('copies');
        }

        $loan->delete();

        return response()->json(['message' => 'Return approved']);
    }

    public function rejectReturn(BorrowedBook $loan)
    {
        if ($loan->status !== 'requested_return') {
            return response()->json(['message' => 'This loan is not pending return approval'], 400);
        }

        $loan->update(['status' => 'borrowed']);

        return response()->json(['message' => 'Return request rejected']);
    }

}
