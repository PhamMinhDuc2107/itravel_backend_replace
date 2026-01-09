<?php

namespace Modules\Shared\Providers;

use Illuminate\Support\ServiceProvider;

class SharedServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Ở Shared thường chỉ bind các dịch vụ tiện ích global
    }

    public function boot(): void
    {
        // Load gì đó nếu cần
    }
}
