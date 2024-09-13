<?php

namespace App\Http\Controllers\api\v1;

use App\Contracts\TokenService;
use App\Contracts\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UsersPaginatedRequest;
use App\Http\Resources\SingleUserResource;
use App\Http\Responses\Api\UsersResponseBuilder;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private TokenService $tokenService;
    private UserService $userService;

    public function __construct(TokenService $tokenService, UserService $userService)
    {
        $this->tokenService = $tokenService;
        $this->userService = $userService;
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

        $user = $this->userService->createUser([
            ...$request->validated(),
            'photo' => 'https://via.placeholder.com/150', // todo, delete after client implementation
        ]);

        $this->tokenService->deleteToken($token); // because valid for only one registration

        return UsersResponseBuilder::userRegistered($user->id);
    }

    public function show(int $id) : JsonResponse
    {
        $userData = new SingleUserResource($this->userService->getUserById($id));

        return UsersResponseBuilder::user($userData);
    }
}
