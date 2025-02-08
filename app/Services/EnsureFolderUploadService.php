<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class EnsureFolderUploadService
{
    public static function makeFolder(string $folderPath, bool $group = true): string
    {
        $fullPath = str_replace('//','/', $folderPath);
        if($group){
            $year = date('Y');
            $month = date('m');
            $fullPath = $folderPath . '/' . $year . '/' . $month;
        }
        File::ensureDirectoryExists($fullPath);
        return rtrim($fullPath, '/');
    }
}
