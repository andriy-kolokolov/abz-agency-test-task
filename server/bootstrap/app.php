<?php

use App\Constants\ResponseStatus;
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
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], ResponseStatus::SERVER_ERROR);
        });
    })->create();

