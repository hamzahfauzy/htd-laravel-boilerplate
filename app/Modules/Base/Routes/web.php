<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function(){
    Route::prefix('profile')->name('profile.')->group(function(){
        Route::get('/', [\App\Modules\Base\Controllers\ProfileController::class, 'index'])->name('index');
        Route::post('/', [\App\Modules\Base\Controllers\ProfileController::class, 'updateImage'])->name('update-image');
        Route::get('edit', [\App\Modules\Base\Controllers\ProfileController::class, 'edit'])->name('edit');
        Route::put('edit', [\App\Modules\Base\Controllers\ProfileController::class, 'update'])->name('update');
    });
});
