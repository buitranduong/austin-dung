<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;
use Spatie\LaravelSettings\SettingsCasts\CollectionCast;

class RedirectSetting extends Settings
{
    public ?array $url_array;

    public static function group(): string
    {
        return 'redirect';
    }
}
