<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath : dirname(__DIR__))
    ->withRouting(
        api    : __DIR__.'/../routes/api.php',
        health : '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            $statusCode = 500;

            throw new HttpException($statusCode, $e->getMessage(), $e);
        });
    })->create();

