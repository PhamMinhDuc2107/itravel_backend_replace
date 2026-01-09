<?php

namespace Modules\Partner\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Partner\Interfaces\PartnerRepositoryInterface;
use Modules\Partner\Repositories\PartnerRepository;

class PartnerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind Interface vào Implementation
        // Khi ai đó xin Interface, Laravel sẽ trả về Repository cụ thể
        $this->app->bind(
            PartnerRepositoryInterface::class,
            PartnerRepository::class
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::prefix('api/v1/partners')
            ->middleware('api')
            ->group(__DIR__ . '/../Routes/api.php');
    }
}
