<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ImageSetting extends Settings
{
    public int $width_featured;
    public int $height_featured;
    public int $width_thumbnail;
    public int $height_thumbnail;
    public int $width_small;
    public int $height_small;
    public string $extension;
    public static function group(): string
    {
        return 'image';
    }
}
