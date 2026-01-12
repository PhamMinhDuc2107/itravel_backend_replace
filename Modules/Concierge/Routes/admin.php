<?php use Illuminate\Support\Facades\Route; use Modules\Concierge\Http\Controllers\Admin\ConciergeController; Route::get('/', [ConciergeController::class, 'index']);
