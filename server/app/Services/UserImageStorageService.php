<?php

namespace App\Services;

use App\Traits\OptimizesImageTrait;
use Illuminate\Support\Facades\Storage;

class UserImageStorageService extends BaseStorageService
{
    use OptimizesImageTrait;

    public function __construct()
    {
        parent::__construct(Storage::disk('local'));
    }

    protected function getFolderPath() : string
    {
        return 'user_images';
    }
}
