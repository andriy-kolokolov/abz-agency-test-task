<?php

namespace App\Services;

use App\Constants\ResponseStatus;
use App\Contracts\TokenRepository;
use App\Contracts\TokenService;
use App\Http\Responses\ApiResponseBuilder;
use App\Models\Token;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;

class TokenServiceImp implements TokenService
{
    private TokenRepository $tokenRepository;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function generateRegistrationToken() : Token
    {
        $tokenExpirationMinutes = config('auth.token.registration.expiration_minutes');
        $tokenName = config('auth.token.registration.name');

        $token = $this->tokenRepository->create([
            'name'       => $tokenName,
            'token'      => hash('sha256', Str::random(40)),
            'expires_at' => now()->addMinutes($tokenExpirationMinutes),
        ]);

        return $token;
    }

    public function validateToken(string|Token $token) : bool
    {
        if ( !$this->tokenRepository->exists($token)) {
            throw new HttpResponseException(ApiResponseBuilder::error(
                message    : __('response_messages.invalid_token'),
                statusCode : ResponseStatus::TOKEN_INVALID,
            ));
        }

        if ($this->tokenRepository->isExpired($token)) {
            throw new HttpResponseException(ApiResponseBuilder::error(
                message    : __('response_messages.token_expired'),
                statusCode : ResponseStatus::TOKEN_EXPIRED,
            ));
        }

        return true;
    }
}