<?php

namespace App\BulkActions;

use Illuminate\Http\UploadedFile;

class UploadImage
{
    public static function make(UploadedFile $file, string $path = '/'): string
    {
        if (!file_exists(public_path("$path"))) {
            mkdir(public_path("$path"), 777, true);
        }

        $clientFilename = $file->getClientOriginalName();
        $file->move($path, $clientFilename);

        return url("$path/$clientFilename");
    }
}
