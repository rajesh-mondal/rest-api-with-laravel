<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get( '/user', function ( Request $request ) {
    return $request->user();
} )->middleware( 'auth:sanctum' );

Route::post( '/register', [AuthController::class, 'register'] );
Route::post( '/login', [AuthController::class, 'login'] );
Route::get( '/login', fn() => response()->json( ['message' => 'Please Login'], 401 ) )->name( 'login' );

Route::middleware( ['auth:sanctum'] )->group( function () {
    Route::post( '/logout', [AuthController::class, 'logout'] );
    Route::get( '/profile', [AuthController::class, 'profile'] );
} );

// Task Manager API : After Login
Route::middleware( ['auth:sanctum'] )->group( function () {
    Route::post( '/tasks/list', [TaskController::class, 'TaskList'] );
    Route::post( '/tasks/create', [TaskController::class, 'TaskCreate'] );
    Route::post( '/tasks/update/{id}', [TaskController::class, 'TaskUpdate'] );
    Route::post( '/tasks/delete/{id}', [TaskController::class, 'TaskDelete'] );
    Route::get( '/tasks/summary', [TaskController::class, 'TaskSummary'] );
} );