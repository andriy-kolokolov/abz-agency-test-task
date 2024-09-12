<?php

namespace App\Providers;

use App\Contracts\TokenService;
use App\Services\TokenServiceImp;
use Illuminate\Support\ServiceProvider;

class InterfaceBindingServiceProvider extends ServiceProvider
{
    private array $servicesMap = [
        TokenService::class => TokenServiceImp::class,
    ];

    /**
     * Register interfaces in laravel service container
     */
    public function register() : void
    {
        foreach ($this->servicesMap as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}