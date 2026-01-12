<?php
namespace Modules\Concierge\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Concierge\Contracts\ConciergeRepositoryContract;
use Modules\Concierge\Repositories\ConciergeRepository;

class ConciergeServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->bind(ConciergeRepositoryContract::class, ConciergeRepository::class);
    }
    public function boot(): void {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::prefix('api/v1/admin/concierge')
            ->middleware(['api', 'auth:admin'])
            ->group(__DIR__ . '/../Routes/admin.php');
    }
}
