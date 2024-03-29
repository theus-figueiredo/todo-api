<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::name('app')->namespace('App\Http\Controllers')->group(function() {
    Route::prefix('/users')->group(function() {
        Route::resource('/', UserController::class);
        Route::post('/login', [LoginController::class, 'login']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update'])->middleware('jwt.auth');
        Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('jwt.auth');
    });

    Route::prefix('/tasks')->middleware('jwt.auth')->group(function() {
        Route::resource('/', TaskController::class);
        Route::get('/{id}', [TaskController::class, 'show']);
        Route::put('/{id}', [TaskController::class, 'update']);
        Route::delete('/{id}', [TaskController::class, 'destroy']);
        Route::get('/mark-completed/{id}', [TaskController::class, 'markTaskAsCompleted']);
    });
});
