<?php

use App\Http\Middleware\Verified;
use App\Libraries\Theme;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Theme::render('welcome');
});

Auth::routes();

Route::middleware(Verified::class)->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::get('/email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/verification-notification', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');