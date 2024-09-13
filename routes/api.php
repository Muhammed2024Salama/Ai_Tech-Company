<?php

use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\Authentications\Controllers\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\Roles\Controllers\ApiRoleController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

/**
 * Authentication Routes
 * These routes are used for user registration, login, and profile management.
 */
Route::controller(AuthController::class)->group(function () {
    // Public routes
    Route::post('register', 'register');
    Route::post('login', 'login');

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', 'userProfile');
        Route::get('logout', 'userLogout');
    });

    Route::apiResource('roles', ApiRoleController::class);

    Route::apiResource('posts', PostController::class);

    Route::apiResource('posts.comments', CommentController::class);

    Route::apiResource('users', ApiUserController::class);
});

