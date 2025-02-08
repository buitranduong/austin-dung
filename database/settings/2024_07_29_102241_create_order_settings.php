<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('order.black_phone', []);
        $this->migrator->add('order.black_ip', []);
    }

    public function down(): void
    {
        $this->migrator->delete('order.black_phone');
        $this->migrator->delete('order.black_ip');
    }
};
