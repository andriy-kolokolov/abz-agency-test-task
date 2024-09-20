<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

abstract class BaseStorageService
{
    abstract protected function getPublicStoragePath() : string;

    public function store(UploadedFile $file) : string
    {
        $filename = time().'_'.$file->getClientOriginalName();
        $publicStoragePath = $this->getPublicStoragePath();

        $file->move(public_path($publicStoragePath), $filename);

        return $this->buildUrl($filename);
    }

    private function resolveHost() : string
    {
        if (app()->environment('production')) {
            return config('app.app_docker_host');
        }

        return config('app.url');
    }

    private function buildUrl(string $filename) : string
    {
        $storagePath = $this->getPublicStoragePath();
        $host = $this->resolveHost();

        return "$host/$storagePath/$filename";
    }
}
