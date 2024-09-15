<?php

namespace App\Providers;

use App\Interface\Authentications\AuthInterface;
use App\Interface\CommentInterface;
use App\Interface\PostInterface;
use App\Interface\RoleInterface;
use App\Interface\SettingInterface;
use App\Interface\UserInterface;
use App\Repository\Authentications\AuthRepository;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\RoleRepository;
use App\Repository\SettingRepository;
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
        $this->app->bind(SettingInterface::class, SettingRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(PostInterface::class, PostRepository::class);
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
