<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserService
{
    public function getAllUsers() : Collection;

    public function createUser(array $validated) : User;

    public function getUserById(int $id) : User;
}