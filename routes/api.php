<?php

use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\Authentications\Controllers\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\Roles\Controllers\ApiRoleController;
use App\Http\Controllers\Api\SettingController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

/**
 * Authentication Routes
 * These routes are used for user registration, login, and profile management.
 */

Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {

        Route::post('register', 'register');
        Route::post('login', 'login');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('user', 'userProfile');
            Route::get('logout', 'userLogout');
        });
    });
});

/**
 * API Resource Routes
 * These routes provide standard CRUD operations for various resources and are protected by Sanctum.
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('roles', ApiRoleController::class);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('posts.comments', CommentController::class);
    Route::apiResource('settings', SettingController::class);
    Route::apiResource('users', ApiUserController::class);
});

/**
 * Public Routes
 * These routes are accessible without authentication.
 */
Route::get('/app-status', [SettingController::class, 'checkAppStatus']);
