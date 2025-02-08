<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class OrderSetting extends Settings
{
    public ?array $black_phone;
    public ?array $black_ip;

    public static function group(): string
    {
        return 'order';
    }
}
