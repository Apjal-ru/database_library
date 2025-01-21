<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});

// Login routes
Route::get('/login', function () {
    return view('auth/login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

// Admin route
Route::get('/index', function () {
    return view('index');
})->middleware(['auth', 'role:admin']);

Route::post('/books', [BookController::class, 'store'])->middleware('auth');
Route::put('/books/{id}', [BookController::class, 'update'])->middleware('auth');
Route::delete('/books/{id}', [BookController::class, 'destroy'])->middleware('auth');

// User route
Route::get('/peminjaman', function () {
    return view('peminjaman');
})->middleware(['auth', 'role:user']);

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
