<?php

namespace App\Providers;

use App\Contracts\TokenRepository;
use App\Contracts\TokenService;
use App\Contracts\UserRepository;
use App\Contracts\UserService;
use App\Repositories\TokenRepositoryImp;
use App\Repositories\UserRepositoryImp;
use App\Services\TokenServiceImp;
use App\Services\UserServiceImp;
use Illuminate\Support\ServiceProvider;

class InterfaceBindingServiceProvider extends ServiceProvider
{
    private array $servicesMap = [
        TokenService::class => TokenServiceImp::class,
        UserService::class  => UserServiceImp::class,
    ];
    private array $repositoriesMap = [
        TokenRepository::class => TokenRepositoryImp::class,
        UserRepository::class  => UserRepositoryImp::class,
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