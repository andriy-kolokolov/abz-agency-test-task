<?php

namespace App\Services;

use App\Contracts\UserRepository;
use App\Contracts\UserService;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Support\Collection;

class UserServiceImp implements UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers() : Collection
    {
        return $this->userRepository->getAll();
    }

    public function getAllUsersPaginated(int $page, int $count) : UserCollection
    {
        $users = $this->userRepository->getAllPaginatedOrderById($page, $count);

        return new UserCollection($users);
    }

    public function createUser(array $validated) : User
    {
        return $this->userRepository->create($validated);
    }

    public function getUserById(int $id) : User
    {
        return $this->userRepository->getById($id);
    }
}
