<?php

namespace App\Contracts;

use App\Models\Token;

interface TokenRepository
{
    public function create(array $data) : Token;

    public function exists(string|Token $token) : bool;

    public function isExpired(string|Token $token) : bool;

    public function delete(string|Token $token) : bool;
}