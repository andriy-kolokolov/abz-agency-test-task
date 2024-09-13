<?php

namespace App\Http\Controllers\api\v1;

use App\Contracts\TokenService;
use App\Http\Controllers\Controller;
use App\Http\Responses\Api\ResponseBuilder;
use Illuminate\Http\JsonResponse;

class TokenController extends Controller
{
    private TokenService $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function __invoke() : JsonResponse
    {
        $token = $this->tokenService->generateRegistrationToken();

        return ResponseBuilder::token(true, $token->token);
    }
}
