<?php

use Illuminate\Support\Facades\Route;
use DJBDeveloper\LaravelAntiReplay\Http\Controllers\VerificationController;

Route::group(['middleware' => 'web'], function () {
    Route::post('/anti-replay/verify', [VerificationController::class, 'verify'])
        ->name('anti-replay.verify');
});