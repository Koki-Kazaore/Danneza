<?php

namespace App\Providers;

use App\Repositories\GoogleUser\GoogleUserRepository;
use App\Repositories\GoogleUser\GoogleUserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GoogleUserRepositoryInterface::class, GoogleUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
