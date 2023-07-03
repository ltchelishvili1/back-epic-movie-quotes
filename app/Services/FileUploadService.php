<?php

namespace App\Services;

class FileUploadService
{
    public function uploadFile($file, $destination)
    {
        $path = $file->store($destination);
        return url('storage/' . $path);
    }
}
