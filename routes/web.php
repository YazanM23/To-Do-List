<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/tasks', [TaskController::class, 'getAllTasks'])->name('tasks');
Route::get('/tasks/{id}/view', [TaskController::class, 'getTaskDetails'])->name('view');
Route::delete('/tasks/{id}/delete', [TaskController::class, 'deleteTask'])->name('delete');
Route::post('/tasks', [TaskController::class, 'createTask'])->name('add');
Route::get('/tasks/{id}/edit', [TaskController::class, 'editTaskDetails'])->name('edit');
Route::put('/tasks/{id}/update', [TaskController::class, 'updateTaskDetails'])->name('update');
Route::put('/tasks/{id}/status', [TaskController::class, 'updateStatus'])->name('updateStatus');
Route::get('/filter', [TaskController::class, 'filterTasks'])->name('filter');
Route::get('/search', [TaskController::class, 'searchTasks'])->name('search');
Route::post('/tasks/{id}/download', [StorageController::class, 'downloadFile'])->name('download');
Route::delete('/tasks/{id}/deleteFile', [StorageController::class, 'deleteFile'])->name('deleteFile');

require __DIR__ . '/auth.php';
