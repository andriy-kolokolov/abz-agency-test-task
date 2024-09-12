<?php

namespace App\Contracts;

use App\Models\Token;

interface TokenService
{
    public function generateRegistrationToken() : Token;
}