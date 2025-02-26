<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AdminController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::post('/books/borrow', [LoanController::class, 'borrow']);
    Route::post('/books/return/{loan_id}', [LoanController::class, 'requestReturn']);

    Route::middleware('admin')->group(function () {
        Route::post('/books', [BookController::class, 'store']);
        Route::put('/books/{book}', [BookController::class, 'update']);
        Route::delete('/books/{book}', [BookController::class, 'destroy']);
        Route::get('/loans', [AdminController::class, 'listLoans']);
        Route::post('/loans/approve/{loan}', [AdminController::class, 'approveReturn']);
        Route::post('/loans/reject/{loan}', [AdminController::class, 'rejectReturn']);
    });
});
