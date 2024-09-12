<?php

namespace App\Providers;

use App\Contracts\TokenRepository;
use App\Contracts\TokenService;
use App\Repositories\TokenRepositoryImp;
use App\Services\TokenServiceImp;
use Illuminate\Support\ServiceProvider;

class InterfaceBindingServiceProvider extends ServiceProvider
{
    private array $servicesMap = [
        TokenService::class => TokenServiceImp::class,
    ];
    private array $repositoriesMap = [
        TokenRepository::class => TokenRepositoryImp::class,
    ];

    /**
     * Register interfaces in laravel service container
     */
    public function register() : void
    {
        foreach ($this->servicesMap as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        foreach ($this->repositoriesMap as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}