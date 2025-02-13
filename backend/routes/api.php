<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeputyController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\LibraryAssistantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookAssignmentController;
use App\Http\Controllers\BookReturnController;
use App\Http\Controllers\BookLoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LibrarianController;

// Middleware with auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Deputy routes
    Route::post('deputy/register-teacher', [DeputyController::class, 'registerTeacher']);
    Route::post('deputy/assign-book', [DeputyController::class, 'assignBook']);

    // Teacher routes
    Route::post('teacher/collect-books', [TeacherController::class, 'collectBooks']);

    // Administrator routes
    Route::post('administrator/validate-return', [AdministratorController::class, 'validateReturn']);

    // Book routes
    Route::post('books', [BookController::class, 'addBook']);
    Route::put('books/{id}', [BookController::class, 'updateBook']);
    Route::delete('books/{id}', [BookController::class, 'deleteBook']);
    Route::get('books/{id}', [BookController::class, 'getBook']);
    Route::get('books', [BookController::class, 'getAllBooks']);

    // Book assignment and return routes
    Route::post('assign-books', [BookAssignmentController::class, 'assignBooks']);
    Route::post('books/{book_id}/return', [BookReturnController::class, 'returnBook']);

    // Book loans routes
    Route::post('book-loans', [BookLoanController::class, 'borrowBook']);
    Route::put('book-loans/{id}/return', [BookLoanController::class, 'returnBook']);
    Route::get('book-loans/user/{user_id}', [BookLoanController::class, 'getUserLoans']);
});

// Public routes (without authentication)
Route::post("register", [UserController::class, "register"]);
Route::post('auth/register-deputy', [AuthController::class, 'registerDeputy']);
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/create-deputy', [AuthController::class, 'createDeputy']);
Route::post('auth/create-teacher-or-administrator', [AuthController::class, 'createTeacherOrAdministrator']);
