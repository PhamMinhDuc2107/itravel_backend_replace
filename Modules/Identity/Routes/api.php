<?php

use Illuminate\Support\Facades\Route;
use Modules\Identity\Http\Controllers\AuthController;

Route::prefix('auth')->group(function () {
    // --- PUBLIC ROUTES (Không cần Token) ---
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);

    // --- PROTECTED ROUTES (Cần Token) ---
    // Sử dụng middleware auth:sanctum để check token hợp lệ (bất kể là admin, partner hay customer)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);

        // API lấy thông tin người dùng hiện tại (Profile)
        Route::get('me', [AuthController::class, 'me']);
    });
});
