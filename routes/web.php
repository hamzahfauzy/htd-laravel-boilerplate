<?php

use App\Http\Middleware\Verified;
use App\Libraries\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Dashboard::getWelcomeScreen();
})->name('welcome');

Auth::routes(['register' => false]);

Route::middleware(Verified::class)->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::get('/email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/verification-notification', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');