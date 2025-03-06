<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookTypeController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::post('/books/borrow', [LoanController::class, 'borrow']);
    Route::post('/books/return/{loan_id}', [LoanController::class, 'requestReturn']);

    Route::middleware('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        Route::post('/books', [BookController::class, 'store']);
        Route::put('/books/{book}', [BookController::class, 'update']);
        Route::delete('/books/{book}', [BookController::class, 'destroy']);
        
        Route::get('/loans', [AdminController::class, 'listLoans']);
        Route::post('/loans/approve/{loan}', [AdminController::class, 'approveReturn']);
        Route::post('/loans/reject/{loan}', [AdminController::class, 'rejectReturn']);

        Route::get('/book-types', [BookTypeController::class, 'index']);
        Route::get('/book-types/{id}', [BookTypeController::class, 'show']);
        Route::post('/book-types', [BookTypeController::class, 'store']);
        Route::put('/book-types/{id}', [BookTypeController::class, 'update']);
        Route::delete('/book-types/{id}', [BookTypeController::class, 'destroy']);
    });
});
