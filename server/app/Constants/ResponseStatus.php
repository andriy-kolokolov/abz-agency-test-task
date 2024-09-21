<?php

namespace App\Constants;

class ResponseStatus
{
    public const OK = 200;
    public const CREATED = 201;
    public const BAD_REQUEST = 400;
    public const TOKEN_EXPIRED = 401;
    public const TOKEN_INVALID = 403;
    public const NOT_FOUND = 404;
    public const CONFLICT = 409;
    public const UNPROCESSABLE_CONTENT = 422;
    public const SERVER_ERROR = 500;
}