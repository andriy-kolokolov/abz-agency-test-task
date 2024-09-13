<?php

namespace App\Http\Responses\Api;

use App\Constants\ResponseStatus;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class UsersResponseBuilder
{
    final public static function userRegistered(int $userId) : JsonResponse
    {
        $response = [
            'success' => true,
            'user_id' => $userId,
            'message' => __('response_messages.users.created'),
        ];

        return response()->json($response, ResponseStatus::CREATED);
    }

    final public static function usersList(array $data) : JsonResponse
    {
        $response = [
            'success' => true,
            ...$data,
        ];

        return response()->json($response, ResponseStatus::OK);
    }

    final public static function user(array|JsonResource $userData) : JsonResponse
    {
        $response = [
            'success' => true,
            'user'    => $userData,
        ];

        return response()->json($response, ResponseStatus::OK);
    }
}