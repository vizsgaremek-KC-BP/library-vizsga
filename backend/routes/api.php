<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookTypeController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/book', [BookController::class, 'show']);
    Route::get('/myLoans', [LoanController::class, 'myLoans']);
    Route::post('/books/return', [LoanController::class, 'requestReturn']);

    Route::middleware('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/user', [UserController::class, 'show']);
        Route::put('/users', [UserController::class, 'update']);
        Route::put('/user/status', [UserController::class, 'updateStatus']);

        Route::post('/books/borrow', [LoanController::class, 'borrow']);
        Route::post('/books', [BookController::class, 'store']);
        Route::put('/books', [BookController::class, 'update']);
        Route::delete('/books', [BookController::class, 'destroy']);

        Route::get('/loans', [AdminController::class, 'listLoans']);
        Route::post('/loans/approve', [AdminController::class, 'approveReturn']);
        Route::post('/loans/reject', [AdminController::class, 'rejectReturn']);
        Route::post('/loans/force', [AdminController::class, 'forceApproveReturn']);

        Route::get('/book-types', [BookTypeController::class, 'index']);
        Route::get('/book-type', [BookTypeController::class, 'show']);
        Route::post('/book-types', [BookTypeController::class, 'store']);
        Route::put('/book-types', [BookTypeController::class, 'update']);
        Route::delete('/book-types', [BookTypeController::class, 'destroy']);

        Route::get('/students', [StudentController::class, 'index']);
        Route::post('/students', [StudentController::class, 'store']);
        Route::get('/student', [StudentController::class, 'show']);
        Route::put('/students', [StudentController::class, 'update']);
        Route::put('/student/status', [StudentController::class, 'updateStatus']);
    });
});
