<?php

namespace Modules\Identity\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Identity\Interfaces\IdentityRepositoryInterface;
use Modules\Identity\Repositories\IdentityRepository;

class IdentityServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind Interface vào Implementation
        // Khi ai đó xin Interface, Laravel sẽ trả về Repository cụ thể
        $this->app->bind(
            IdentityRepositoryInterface::class,
            IdentityRepository::class
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::prefix('api/v1/identitys')
            ->middleware('api')
            ->group(__DIR__ . '/../Routes/api.php');
    }
}
