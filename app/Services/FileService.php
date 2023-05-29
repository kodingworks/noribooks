<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileService 
{
    public function uploadFile($file)
    {
        $fileName = Str::random(60);
        $extension = $file->getClientOriginalExtension();
        $path = date('Y') . '/' . date('m') . '/' . date('d');
        $pathName = '/storage/file/' . $path . '/' . $fileName . '.' . $extension;

        Storage::put('/public/file/' . $path . '/' . $fileName . '.' . $extension, File::get($file));

        return config('app.file_upload_endpoint') . $pathName;
    }
}
