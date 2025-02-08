<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('warehouse.filter_percent_rates', []);
    }

    public function down(): void
    {
        $this->migrator->delete('warehouse.filter_percent_rates');
    }
};
