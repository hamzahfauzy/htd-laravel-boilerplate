<?php

use App\Http\Middleware\Cors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function () {
    Route::post('login', [\App\Http\Controllers\Api\LoginController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\Api\LoginController::class, 'register']);
    Route::post('forgot-password', [\App\Http\Controllers\Api\LoginController::class, 'forgotPassword']);
    Route::post('reset-password', [\App\Http\Controllers\Api\LoginController::class, 'resetPassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});
