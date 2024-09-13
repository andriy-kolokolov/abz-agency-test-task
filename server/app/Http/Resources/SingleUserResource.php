<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class SingleUserResource extends JsonResource
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
            'photo'                  => $this->photo,
        ];
    }
}
