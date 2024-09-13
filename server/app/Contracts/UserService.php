<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserService
{
    public function getAllUsers() : Collection;

    public function createUser(array $validated) : bool;

    public function getUserById(int $id) : User;
}