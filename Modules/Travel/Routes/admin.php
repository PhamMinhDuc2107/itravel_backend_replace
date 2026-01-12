<?php use Illuminate\Support\Facades\Route; use Modules\Travel\Http\Controllers\Admin\TravelController; Route::get('/', [TravelController::class, 'index']);
