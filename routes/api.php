<?php

use App\Http\Controllers\API\ActivityLogController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/v1', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API is running smoothly'
    ]);
});

Route::prefix('/v1')->group(function() {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('posts', PostController::class);
    });

    Route::get('/activity-logs', [ActivityLogController::class, 'index']);
});

