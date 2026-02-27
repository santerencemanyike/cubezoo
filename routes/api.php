<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\AuthController;
use App\Http\Controllers\Api\V1\Admin\SiteController;
use App\Http\Controllers\Api\V1\Admin\VisitController;
use App\Http\Controllers\Api\V1\Admin\SiteVisitController;

Route::prefix('v1')->group(function () {

    // Public authentication
    Route::post('/auth/login', [AuthController::class, '__invoke']);
    Route::post('/auth/register', [AuthController::class, 'register']);

    // Protected
    Route::middleware('auth:sanctum')->group(function () {

        // Sites
        Route::post('/sites', [SiteController::class, 'store']);
        Route::get('/sites', [SiteController::class, 'index']);

        // Visits
        Route::get('/visits', [VisitController::class, 'index']);
        Route::post('/visits', [VisitController::class, 'store']);
        Route::post('/visits/{visit}/submit', [VisitController::class, 'submit']);

        // Site visits (admin)
        Route::get('/sites/{site}/visits', [SiteVisitController::class, 'index']);
    });
});
