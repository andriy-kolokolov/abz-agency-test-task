<?php

namespace App\Http\Responses\Api;

use App\Constants\ResponseStatus;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Http\JsonResponse;

class ResponseBuilder
{
    final public static function success(array $data = null, string $message = '', int $statusCode = ResponseStatus::OK) : JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ];

        return response()->json($response, $statusCode);
    }

    final public static function error(string $message = '', MessageBag|array $errors = null, int $statusCode = ResponseStatus::BAD_REQUEST) : JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ];

        return response()->json($response, $statusCode);
    }

    final public static function conflict(string $message) : JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        return response()->json($response, ResponseStatus::CONFLICT);
    }

    final public static function token(string $token) : JsonResponse
    {
        $response = [
            'success' => true,
            'token'   => $token,
        ];

        return response()->json($response, ResponseStatus::OK);
    }
}