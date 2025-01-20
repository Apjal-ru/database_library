<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
