<?php

namespace App\Contracts;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface UserService
{
    public function getAllUsers() : Collection;

    public function getAllUsersPaginated(int $page, int $count) : UserCollection;

    public function createUser(array $validated, UploadedFile $userImage) : User;

    public function getUserById(int $id) : User;
}