<?php

namespace App\Providers;

use App\Interface\Authentications\AuthInterface;
use App\Interface\RoleInterface;
use App\Repository\Authentications\AuthRepository;
use App\Repository\RoleRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
