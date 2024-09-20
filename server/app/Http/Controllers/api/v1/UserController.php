<?php

namespace App\Http\Controllers\api\v1;

use App\Contracts\TokenService;
use App\Contracts\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UsersPaginatedRequest;
use App\Http\Resources\SingleUserResource;
use App\Http\Responses\Api\UsersResponseBuilder;
use App\Services\UserImageStorageService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private TokenService $tokenService;
    private UserService $userService;
    private UserImageStorageService $fileStorageService;

    public function __construct(
        TokenService            $tokenService,
        UserService             $userService,
        UserImageStorageService $fileStorageService,
    ) {
        $this->tokenService = $tokenService;
        $this->userService = $userService;
        $this->fileStorageService = $fileStorageService;
    }

    public function index(UsersPaginatedRequest $request) : JsonResponse
    {
        $page = $request->validated('page', 1);
        $perPage = $request->validated('count', 5);

        $usersData = $this->userService->getAllUsersPaginated($page, $perPage)
            ->toArray($request);

        return UsersResponseBuilder::usersList($usersData);
    }

    public function store(RegisterRequest $request) : JsonResponse
    {
        $token = $request->header('Token');

        $this->tokenService->validateToken($token);

        $url = $this->fileStorageService->store($request->file('photo'));

        $user = $this->userService->createUser([
            ...$request->validated(),
            'photo' => $url,
        ]);

        $this->tokenService->deleteToken($token);

        return UsersResponseBuilder::userRegistered($user->id);
    }

    public function show(int $id) : JsonResponse
    {
        $userData = new SingleUserResource($this->userService->getUserById($id));

        return UsersResponseBuilder::user($userData);
    }
}
