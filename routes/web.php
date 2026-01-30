<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

// Redirect root to todos
Route::get('/', function () {
    return redirect()->route('todos.index');
});

// Todo routes
Route::resource('todos', TodoController::class);
Route::post('todos/{todo}/toggle', [TodoController::class, 'toggleComplete'])->name('todos.toggle');

// Category routes
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// Tag routes
Route::get('tags', [TagController::class, 'index'])->name('tags.index');
Route::post('tags', [TagController::class, 'store'])->name('tags.store');
Route::put('tags/{tag}', [TagController::class, 'update'])->name('tags.update');
Route::delete('tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
