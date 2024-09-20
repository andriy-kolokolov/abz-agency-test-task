<?php

namespace App\Services;

class UserImageStorageService extends BaseStorageService
{
    protected function getPublicStoragePath() : string
    {
        return 'public/user_images';
    }
}