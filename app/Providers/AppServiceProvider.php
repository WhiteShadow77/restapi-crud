<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\ResponseService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(ResponseService::class, function(){
            return new ResponseService();
        });

        $this->app->singleton(AuthService::class, function(){
            return new AuthService($this->app->make(ResponseService::class));
        });

    }
}
