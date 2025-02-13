<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Bejelentkezés
    public function login(Request $request)
    {
        // Validáljuk a bejelentkezési adatokat
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Próbálunk bejelentkezni a megadott adatokkal
        if (Auth::attempt($request->only('email', 'password'))) {
            // Sikeres bejelentkezés után
            return response()->json(['message' => 'Bejelentkezés sikeres']);
        }

        // Ha a bejelentkezés nem sikerül
        return response()->json(['message' => 'Hibás email vagy jelszó'], 401);
    }

    // Kijelentkezés
    public function logout(Request $request)
    {
        Auth::logout(); // Kiléptetjük a felhasználót
        return response()->json(['message' => 'Kijelentkezés sikeres']);
    }
}
