<?php

namespace App\Http\Controllers;

use App\Http\Resources\PositionResource;
use App\Http\Responses\Api\PositionsResponseBuilder;
use App\Models\Position;
use Illuminate\Http\JsonResponse;

class PositionController extends Controller
{
    public function __invoke() : JsonResponse
    {
        $positions = Position::all(['id', 'name']);

        $positionsFormatted = PositionResource::collection($positions);

        return PositionsResponseBuilder::positionsList($positionsFormatted);
    }
}
