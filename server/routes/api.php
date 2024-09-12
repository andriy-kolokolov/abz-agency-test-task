<?php

use App\Constants\ResponseStatus;
use App\Http\Controllers\api\v1\TokenController;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Responses\ApiResponseBuilder;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/token', TokenController::class);

    Route::prefix('/users')->group(function () {
        Route::post('/', [UserController::class, 'store']);
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
    });
});

Route::fallback(function () {
    return ApiResponseBuilder::error(
        message    : __('response_messages.page_not_found'),
        statusCode : ResponseStatus::NOT_FOUND,
    );
});