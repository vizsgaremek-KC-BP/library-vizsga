<?php

namespace App\Http\Controllers;

use App\Models\BookReturn;
use Illuminate\Http\Request;

class BookReturnController extends Controller
{

    public function returnBook(Request $request, $book_id)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $return = BookReturn::create([
            'book_id' => $book_id,
            'user_id' => $validated['user_id'],
            'is_returned' => true,
        ]);

        return response()->json($return, 201);
    }
}