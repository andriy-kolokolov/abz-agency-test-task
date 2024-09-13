<?php

namespace App\Http\Resources;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Position */
class PositionResource extends JsonResource
{
    public function toArray(Request $request) : array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
        ];
    }
}
