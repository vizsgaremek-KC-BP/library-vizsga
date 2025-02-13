<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Felhasználó regisztrálása
    public function register(Request $request)
    {
        // Validáljuk a regisztrációs adatokat
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Új felhasználó létrehozása
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Jelszó titkosítása
        ]);

        // Felhasználó regisztráció után
        return response()->json(['message' => 'Sikeres regisztráció', 'user' => $user], 201);
    }
}
