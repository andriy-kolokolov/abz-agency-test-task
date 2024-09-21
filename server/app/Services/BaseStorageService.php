<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;

abstract class BaseStorageService
{
    private Filesystem $storage;

    public function __construct(Filesystem $storage)
    {
        $this->storage = $storage;
    }

    abstract protected function getFolderPath() : string;

    final public function store(UploadedFile $file) : string
    {
        $filename = $this->makeFileName($file);

        $this->storage->putFileAs($this->getFolderPath(), $file, $filename);

        return $this->makeUrl($filename);
    }

    private function makeUrl(string $filename) : string
    {
        return $this->storage->url($this->getFolderPath().'/'.$filename);
    }

    private function makeFileName(UploadedFile $file) : string
    {
        return time().'_'.$file->getClientOriginalName();
    }
}
