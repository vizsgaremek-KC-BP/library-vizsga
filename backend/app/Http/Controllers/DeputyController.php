<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeputyController extends Controller
{
    public function registerTeacher(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'teacher',
        ]);

        return response()->json($user, 201);
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
