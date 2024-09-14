<?php

namespace App\Providers;

use App\Interface\Authentications\AuthInterface;
use App\Interface\CommentInterface;
use App\Interface\RoleInterface;
use App\Interface\UserInterface;
use App\Repository\Authentications\AuthRepository;
use App\Repository\CommentRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
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
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(CommentInterface::class, CommentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
