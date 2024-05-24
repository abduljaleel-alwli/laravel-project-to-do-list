<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// ToDoList Routes
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus']);
    Route::post('/tasks/{taskId}/delete-task', [TaskController::class, 'deleteTask']);
});