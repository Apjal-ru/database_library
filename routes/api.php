<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LogController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/books', [BookController::class, 'index']);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::post('/peminjaman', [PeminjamanController::class, 'store']);
Route::get('/peminjaman', [PeminjamanController::class, 'index']);
Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy']);
Route::get('/logs', [LogController::class, 'getLogs']);
