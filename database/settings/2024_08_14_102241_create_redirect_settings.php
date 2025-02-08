<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('redirect.url_array', []);
    }

    public function down(): void
    {
        $this->migrator->delete('redirect.url_array');
    }
};
