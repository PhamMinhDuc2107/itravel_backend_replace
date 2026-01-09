<?php

namespace Modules\Hotel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Hotel\Interfaces\HotelRepositoryInterface;
use Modules\Hotel\Repositories\HotelRepository;

class HotelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind Interface vào Implementation
        // Khi ai đó xin Interface, Laravel sẽ trả về Repository cụ thể
        $this->app->bind(
            HotelRepositoryInterface::class,
            HotelRepository::class
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::prefix('api/v1/hotels')
            ->middleware('api')
            ->group(__DIR__ . '/../Routes/api.php');
    }
}
