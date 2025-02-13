<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function collectBooks(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $loans = BookLoan::where('user_id', $validated['user_id'])
                        ->where('is_returned', false)
                        ->with('book')
                        ->get();

        if ($loans->isEmpty()) {
            return response()->json(['message' => 'No books to collect.'], 400);
        }

        foreach ($loans as $loan) {
            $loan->is_returned = true;
            $loan->returned_at = now();
            $loan->save();
        }

        return response()->json(['message' => 'Books collected successfully.', 'loans' => $loans], 200);
    }
}