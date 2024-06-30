<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    public static function saveImage($image, $folder)
    {
        $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('public/' . $folder, $imageName);
        return Storage::url($path);
    }
}
