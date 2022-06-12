<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskNotesController;
use App\Http\Controllers\AuthenticationController;

Route::middleware('auth:sanctum')->group(function () {
    // Task controller
    Route::get('task', [TaskController::class, 'index']);
    Route::post('/add-task', [TaskController::class, 'store']);
    Route::get('/edit-task/{id}', [TaskController::class, 'edit']);
    Route::put('/update-task/{id}', [TaskController::class, 'update']);
    Route::delete('/delete-task/{id}', [TaskController::class, 'destroy']);

    // Notes controller
    Route::get('notes', [TaskNotesController::class, 'index']);
    Route::post('/add-notes', [TaskNotesController::class, 'store']);
    Route::get('/edit-notes/{id}', [TaskNotesController::class, 'edit']);
    Route::put('/update-notes/{id}', [TaskNotesController::class, 'update']);
    Route::delete('/delete-notes/{id}', [TaskNotesController::class, 'destroy']);
    
});
Route::post('login', [AuthenticationController::class, 'login']);
Route::post('register', [AuthenticationController::class, 'register']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
