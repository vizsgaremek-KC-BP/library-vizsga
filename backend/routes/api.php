<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Csak bejelentkezett felhasználóknak
Route::middleware('auth:api')->get('me', [AuthController::class, 'me']);


// Admin felhasználóknak
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::post('books', [BookController::class, 'addBook']);
});

// Könyvtárosoknak
Route::middleware(['auth:api', 'role:librarian'])->group(function () {
    Route::put('books/{id}', [BookController::class, 'updateBookStatus']);
});

// Minden bejelentkezett felhasználónak
Route::middleware('auth:api')->get('books', [BookController::class, 'getBooks']);


// Admin felhasználóknak
Route::middleware([RoleMiddleware::class.':admin'])->group(function () {
    Route::post('books', [BookController::class, 'addBook']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('books', [BookController::class, 'addBook']);
    Route::get('books', [BookController::class, 'getBooks']);
    Route::put('books/{id}', [BookController::class, 'updateBookStatus']);
});


