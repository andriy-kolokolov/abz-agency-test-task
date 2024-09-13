<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepository
{
    public function getAll() : Collection;

    public function create(array $validated) : User;

    public function getById(int $id) : User;
}