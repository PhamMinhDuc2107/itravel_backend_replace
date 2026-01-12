<?php
namespace Modules\Travel\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Travel\Contracts\TravelRepositoryContract;
use Modules\Travel\Repositories\TravelRepository;

class TravelServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->bind(TravelRepositoryContract::class, TravelRepository::class);
    }
    public function boot(): void {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::prefix('api/v1/admin/travel')
            ->middleware(['api', 'auth:admin'])
            ->group(__DIR__ . '/../Routes/admin.php');
    }
}
