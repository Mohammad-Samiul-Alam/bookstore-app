<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', [BookController::class, 'book'])->name('book');
Route::get('/book/add', [BookController::class, 'book_add'])->name('book.add');
Route::post('/book/store', [BookController::class, 'book_store'])->name('book.store');
Route::get('/book/edit/{book_id}', [BookController::class, 'book_edit'])->name('book.edit');
Route::post('/book/update', [BookController::class, 'book_update'])->name('book.update');
Route::get('/book/delete/{book_id}', [BookController::class, 'book_delete'])->name('book.delete');
Route::get('/book/info/{book_id}', [BookController::class, 'book_info'])->name('book.info');
