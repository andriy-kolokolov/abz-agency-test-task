<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public function toArray(Request $request) : array
    {
        return [
            'page'        => $this->currentPage(),
            'total_pages' => $this->lastPage(),
            'total_users' => $this->total(),
            'count'       => $this->count(),
            'links'       => [
                'next_url' => $this->nextPageUrl(),
                'prev_url' => $this->previousPageUrl(),
            ],
            'users'       => UserResource::collection($this->collection),
        ];
    }
}
