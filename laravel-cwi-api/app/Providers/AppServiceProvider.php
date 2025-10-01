<?php

namespace App\Providers;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\ExternalServiceClientInterface;
use App\Repositories\UsersRepository;
use App\Services\ExternalServiceClient;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UsersRepository::class);
        $this->app->bind(ExternalServiceClientInterface::class, ExternalServiceClient::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
