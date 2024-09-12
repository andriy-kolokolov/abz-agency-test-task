<?php

namespace App\Http\Controllers\api\v1;

use App\Contracts\TokenService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private TokenService $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function index() : JsonResponse
    {
        // TODO
    }

    public function store(RegisterRequest $request) : JsonResponse
    {
        $token = $request->header('Token');

        $this->tokenService->validateToken($token);

        // TODO
    }

    public function show(int $id) : JsonResponse
    {
        // TODO
    }
}
