<?php use Illuminate\Support\Facades\Route; use Modules\Flight\Http\Controllers\Admin\FlightController; Route::get('/', [FlightController::class, 'index']);
