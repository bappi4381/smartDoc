<?php

namespace App\Providers;

use App\Repositories\Contracts\DiagnosticCenterRepositoryInterface;
use App\Repositories\Eloquent\DiagnosticCenterRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DiagnosticCenterRepositoryInterface::class, DiagnosticCenterRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
