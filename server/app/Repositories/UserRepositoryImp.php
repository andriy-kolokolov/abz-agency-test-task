<?php

namespace App\Repositories;

use App\Contracts\UserRepository;
use App\Models\User;
use Illuminate\Support\Collection;

class UserRepositoryImp implements UserRepository
{
    public function getAll() : Collection
    {
        return User::all();
    }

    public function create(array $validated) : User
    {
        return User::create($validated);
    }

    public function getById(int $id) : User
    {
        return User::findOrFail($id);
    }
}