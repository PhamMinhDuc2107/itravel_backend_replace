<?php

namespace Modules\Tour\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Tour\Interfaces\TourRepositoryInterface;
use Modules\Tour\Repositories\TourRepository;

class TourServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind Interface vào Implementation
        // Khi ai đó xin Interface, Laravel sẽ trả về Repository cụ thể
        $this->app->bind(
            TourRepositoryInterface::class,
            TourRepository::class
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::prefix('api/v1/tours')
            ->middleware('api')
            ->group(__DIR__ . '/../Routes/api.php');
    }
}
