<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageHelper
{
    public function uploadToServer(String $location, $file)
    {
        $uploadFile = $file;
        $uploadFile->storeAs($location, $uploadFile->hashName());
        return $uploadFile->hashName();
    }

    public function deleteFromServer(String $disk, String $path): void
    {
        Storage::disk($disk)->delete($path);
    }
}
