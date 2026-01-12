<?php
namespace Modules\Identity\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
class IdentityServiceProvider extends ServiceProvider {
    public function boot(): void {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::prefix('api/v1/auth')->middleware('api')->group(__DIR__ . '/../Routes/api.php');
    }
    public function register(): void {
        $this->app->bind('');
    }
}
