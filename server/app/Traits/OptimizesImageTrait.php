<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use function Tinify\fromFile;
use function Tinify\setKey;

trait OptimizesImageTrait
{
    public function optimize(UploadedFile $image) : UploadedFile
    {
        $apiKey = config('services.tiny_png.api_key');

        setKey($apiKey);

        $source = fromFile($image->path());

        $resized = $source->resize([
            "method" => "cover",
            "width"  => 70,
            "height" => 70,
        ]);

        $resized->toFile($image->path());

        return $image;
    }
}