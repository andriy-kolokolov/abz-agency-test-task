<?php

namespace App\Repositories;

use App\Contracts\UserRepository;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserRepositoryImp implements UserRepository
{
    public function getAll() : Collection
    {
        return User::all();
    }

    public function getAllPaginatedOrderById(int $page, int $count) : LengthAwarePaginator
    {
        return User::with('position')
            ->orderBy('id')
            ->paginate(perPage : $count, page : $page);
    }

    public function create(array $validated) : User
    {
        return User::create($validated);
    }

    public function getById(int $id) : User
    {
        return User::with('position')->findOrFail($id);
    }
}