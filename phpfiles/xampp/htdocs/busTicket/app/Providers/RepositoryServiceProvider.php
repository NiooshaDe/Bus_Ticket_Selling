<?php

namespace App\Providers;

use App\Repositories\LandingRepositoryInterface;
use App\Repositories\ShowCompaniesRepository;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LandingRepositoryInterface::class, ShowCompaniesRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
