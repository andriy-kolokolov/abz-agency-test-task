<?php

namespace App\Services;

use App\Contracts\UserRepository;
use App\Contracts\UserService;
use App\Http\Resources\UserCollection;
use App\Http\Responses\Api\ResponseBuilder;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class UserServiceImp implements UserService
{
    private UserRepository $userRepository;
    private UserImageStorageService $imageService;

    public function __construct(
        UserRepository          $userRepository,
        UserImageStorageService $imageService,
    ) {
        $this->userRepository = $userRepository;
        $this->imageService = $imageService;
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

    public function createUser(array $validated, UploadedFile $userImage) : User
    {
        $optimizedImage = $this->imageService->optimize($userImage);

        $url = $this->imageService->store($optimizedImage);

        return $this->userRepository->create([
            ...$validated,
            'photo' => $url,
        ]);
    }

    public function getUserById(int $id) : User
    {
        try {
            return $this->userRepository->getById($id);
        } catch (ModelNotFoundException $e) {
            throw new HttpResponseException(
                ResponseBuilder::error(__('response_messages.users.not_found')),
            );
        }
    }
}
