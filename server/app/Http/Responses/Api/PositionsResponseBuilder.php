<?php

namespace App\Http\Responses\Api;

use App\Constants\ResponseStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class PositionsResponseBuilder
{
    final public static function positionsList(array|JsonResource $positionsData) : JsonResponse
    {
        $response = [
            'success'   => true,
            'positions' => $positionsData,
        ];

        return response()->json($response, ResponseStatus::OK);
    }
}