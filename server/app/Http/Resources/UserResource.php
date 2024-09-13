<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request) : array
    {
        return [
            'id'                     => $this->id,
            'name'                   => $this->name,
            'email'                  => $this->email,
            'phone'                  => $this->phone,
            'position'               => $this->position->name,
            'position_id'            => $this->position_id,
            'registration_timestamp' => $this->created_at->timestamp,
            'photo'                  => $this->photo,
        ];
    }
}
