<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Pets\PetRepositoryInterface;
use App\Repositories\Pets\EloquentPetRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\Repositories\Users\EloquentUserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PetRepositoryInterface::class, EloquentPetRepository::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
