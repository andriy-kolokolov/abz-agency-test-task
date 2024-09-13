<?php

namespace App\Contracts;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Support\Collection;

interface UserService
{
    public function getAllUsers() : Collection;

    public function getAllUsersPaginated(int $page, int $count) : UserCollection;

    public function createUser(array $validated) : User;

    public function getUserById(int $id) : User;
}