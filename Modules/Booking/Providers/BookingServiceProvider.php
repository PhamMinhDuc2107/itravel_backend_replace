<?php

namespace Modules\Booking\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Booking\Interfaces\BookingRepositoryInterface;
use Modules\Booking\Repositories\BookingRepository;

class BookingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind Interface vào Implementation
        // Khi ai đó xin Interface, Laravel sẽ trả về Repository cụ thể
        $this->app->bind(
            BookingRepositoryInterface::class,
            BookingRepository::class
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::prefix('api/v1/bookings')
            ->middleware('api')
            ->group(__DIR__ . '/../Routes/api.php');
    }
}
