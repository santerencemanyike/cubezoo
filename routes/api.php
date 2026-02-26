<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\AuthController;
use App\Http\Controllers\Api\V1\Admin\SiteController;
use App\Http\Controllers\Api\V1\Admin\VisitController;
use App\Http\Controllers\Api\V1\Admin\SiteVisitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::prefix('v1')->group(function () {

    // Public login
    Route::post('/auth/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = User::where('email', $credentials['email'])->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    });

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
