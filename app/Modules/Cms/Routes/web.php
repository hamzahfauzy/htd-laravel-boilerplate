<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('cms')->group(function(){
    Route::post('upload-media', [\App\Modules\Cms\Controllers\MediaController::class, 'upload'])->name('upload-media');
});
