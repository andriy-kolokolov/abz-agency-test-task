<?php

namespace App\Http\Responses\Api;

use App\Constants\ResponseStatus;
use Illuminate\Http\JsonResponse;

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
}