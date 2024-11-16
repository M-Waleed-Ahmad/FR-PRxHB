<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\OrderController;

use App\Http\Controllers\AuthController;

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');


Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/users', [AuthController::class, 'getUsers']);
    Route::post('/users', [AuthController::class, 'createUser']);
    Route::get('/users/{id}', [AuthController::class, 'getUser']);
    Route::put('/users/{id}', [AuthController::class, 'updateUser']);
    Route::delete('/users/{id}', [AuthController::class, 'deleteUser']);
    Route::get('/users/search/{query}', [AuthController::class, 'searchUsers']);

    Route::get('/categories', [CategoryController::class, 'getCategories']);
    Route::post('/categories', [CategoryController::class, 'createCategory']);
    Route::put('/categories/{id}', [CategoryController::class, 'updateCategory']);
    Route::get('/categories/{id}', [CategoryController::class, 'getCategory']);
    Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory']);
    Route::get('/categories/search/{query}', [CategoryController::class, 'searchCategories']);

    Route::get('/books', [BookController::class, 'getBooks']);
    Route::post('/books', [BookController::class, 'createBook']);
    Route::get('/books/{id}', [BookController::class, 'getBook']);
    Route::put('/books/{id}', [BookController::class, 'updateBook']);
    Route::delete('/books/{id}', [BookController::class, 'deleteBook']);
    Route::get('/books/search/{query}', [BookController::class, 'searchBooks']);
});
Route::get('/categories', [CategoryController::class, 'getCategories'])->name('categories.index');
Route::get('/book/category/{id}', [BookController::class, 'getBooksByCategory'])->name('books.category');
Route::post('/order', [OrderController::class, 'placeOrder'])->middleware('auth')->name('order.place');
Route::get('/order', [OrderController::class, 'index'])->middleware('auth')->name('orders.index');
Route::delete('/order/{id}', [OrderController::class, 'cancelOrder'])->middleware('auth')->name('order.cancel');
Route::get('/', function () {
    return view('welcome');
});

