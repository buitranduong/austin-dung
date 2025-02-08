<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class WarehouseSetting extends Settings
{
    public int $sim_update_lt_days;
    public bool $is_only_warehouse;
    public array $priority_warehouse;
    public array $ignores_warehouse;
    public array $sim_hidden;
    public array $percent_rates;
    public array $filter_percent_rates;
    public int | null $priority_price_min;
    public int | null $priority_price_max;
    public string $sort_default;
    public static function group(): string
    {
        return 'warehouse';
    }
}
