<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserRepository
{
    public function getAll() : Collection;

    public function getAllPaginatedOrderById(int $page, int $count) : LengthAwarePaginator;

    public function create(array $validated) : User;

    public function getById(int $id) : User;
}