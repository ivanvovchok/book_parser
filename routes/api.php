<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/books', [BookController::class, 'index']);
Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/{author}/books', [AuthorController::class, 'books']);
