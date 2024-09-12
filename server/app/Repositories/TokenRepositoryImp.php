<?php

namespace App\Repositories;

use App\Contracts\TokenRepository;
use App\Models\Token;

class TokenRepositoryImp implements TokenRepository
{
    public function create(array $data) : Token
    {
        return Token::create($data);
    }

    public function exists(string|Token $token) : bool
    {
        if ($token instanceof Token) {
            $token = $token->token;
        }

        return Token::where('token', $token)->exists();
    }

    public function isExpired(string|Token $token) : bool
    {
        if ($token instanceof Token) {
            $token = $token->token;
        }

        return Token::where('token', $token)
            ->where('expires_at', '<', now())
            ->exists();
    }
}