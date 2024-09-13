<?php

namespace App\Http\Controllers\api\v1;

use App\Contracts\TokenService;
use App\Contracts\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Responses\Api\UsersResponseBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private TokenService $tokenService;
    private UserService $userService;

    public function __construct(TokenService $tokenService, UserService $userService)
    {
        $this->tokenService = $tokenService;
        $this->userService = $userService;
    }

    public function index(Request $request) : JsonResponse
    {
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
        // TODO
    }
}
