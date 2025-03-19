<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowedBook;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function listLoans()
    {
        $loans = BorrowedBook::with(['user', 'book.bookType'])->get();
        return response()->json($loans);
    }

    public function approveReturn(Request $request)
    {
        $loan = BorrowedBook::where('id', $request->loan_id)->first();
        if (!$loan || $loan->status !== 'requested_return') {
            return response()->json(['message' => 'This loan is not pending return approval'], 400);
        }

        DB::transaction(function () use ($loan) {
            if ($loan->book && $loan->book->bookType) {
                $loan->book->bookType->increment('copies');
            }
            $loan->update(['status' => 'returned']);
        });

        return response()->json(['message' => 'Return approved']);
    }

    public function rejectReturn(Request $request)
    {
        $loan = BorrowedBook::where('id', $request->loan_id)->first();
        if (!$loan || $loan->status !== 'requested_return') {
            return response()->json(['message' => 'This loan is not pending return approval'], 400);
        }

        $loan->update(['status' => 'borrowed']);

        return response()->json(['message' => 'Return request rejected']);
    }

    public function forceApproveReturn(Request $request)
    {
        $loan = BorrowedBook::where('id', $request->loan_id)->first();
        if (!$loan || $loan->status === 'returned') {
            return response()->json(['message' => 'This loan has already been returned or does not exist'], 400);
        }

        DB::transaction(function () use ($loan) {
            if ($loan->book && $loan->book->bookType) {
                $loan->book->bookType->increment('copies');
            }
            $loan->update(['status' => 'returned']);
        });

        return response()->json(['message' => 'Return approved (forced)']);
    }
}