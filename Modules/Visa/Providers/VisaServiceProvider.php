<?php

namespace Modules\Visa\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Visa\Interfaces\VisaRepositoryInterface;
use Modules\Visa\Repositories\VisaRepository;

class VisaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind Interface vào Implementation
        // Khi ai đó xin Interface, Laravel sẽ trả về Repository cụ thể
        $this->app->bind(
            VisaRepositoryInterface::class,
            VisaRepository::class
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::prefix('api/v1/visas')
            ->middleware('api')
            ->group(__DIR__ . '/../Routes/api.php');
    }
}
