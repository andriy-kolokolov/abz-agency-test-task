<?php

namespace App\Services;

use App\Contracts\TokenService;
use App\Models\Token;
use Illuminate\Support\Str;

class TokenServiceImp implements TokenService
{
    public function generateRegistrationToken() : Token
    {
        $tokenExpirationMinutes = config('auth.token.registration.expiration_minutes');

        $token = Token::create([
            'name'       => 'registration_token',
            'token'      => hash('sha256', Str::random(40)),
            'expires_at' => now()->addMinutes($tokenExpirationMinutes),
        ]);

        return $token;
    }
}