<?php
namespace Modules\Shared\Providers;
use Illuminate\Support\ServiceProvider;

class SharedServiceProvider extends ServiceProvider {
    public function boot(): void {
        // Load migrations chung (nếu có, ví dụ bảng logs)
        // $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
