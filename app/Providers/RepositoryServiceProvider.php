<?php

namespace App\Providers;

use App\Interfaces\CompanyInterface;
use App\Interfaces\JobInterface;
use App\Repositories\CompanyRepository;
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
        $this->app->bind(CompanyInterface::class, CompanyRepository::class);
        $this->app->bind(JobInterface::class, JobRepository::class);
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
