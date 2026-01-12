<?php
namespace Modules\Flight\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Flight\Contracts\FlightRepositoryContract;
use Modules\Flight\Repositories\FlightRepository;

class FlightServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->bind(FlightRepositoryContract::class, FlightRepository::class);
    }
    public function boot(): void {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::prefix('api/v1/admin/flight')
            ->middleware(['api', 'auth:admin'])
            ->group(__DIR__ . '/../Routes/admin.php');
    }
}
