<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:api')->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
});

// Task management routes - protected by authentication
Route::middleware('auth:api')->group(function () {
    Route::get('tasks', [TaskController::class, 'index']);           // GET /api/tasks
    Route::post('tasks', [TaskController::class, 'store']);          // POST /api/tasks
    Route::get('tasks/{id}', [TaskController::class, 'show']);       // GET /api/tasks/{id}
    Route::put('tasks/{id}', [TaskController::class, 'update']);     // PUT /api/tasks/{id}
    Route::delete('tasks/{id}', [TaskController::class, 'destroy']); // DELETE /api/tasks/{id}
});