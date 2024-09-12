<?php

namespace App\Contracts;

use App\Models\Token;

interface TokenService
{
    public function generateRegistrationToken() : Token;

    public function validateToken(string $token) : bool;
}