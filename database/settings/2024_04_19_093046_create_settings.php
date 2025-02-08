<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Sim Thăng Long');
        $this->migrator->add('general.site_description', 'Sim Thăng Long');
        $this->migrator->add('general.head_script_before', '');
        $this->migrator->add('general.head_script_after', '');
        $this->migrator->add('general.body_script_before', '');
        $this->migrator->add('general.body_script_after', '');
        $this->migrator->add('general.sim_limit', 50);

        $this->migrator->add('hotline.seller', '024.6666.6666');
        $this->migrator->add('hotline.zalo', 'https://zalo.me/2966339375592441251');
        $this->migrator->add('hotline.phone', '098.365.6699');

        $this->migrator->add('warehouse.sim_update_lt_days', 62);
        $this->migrator->add('warehouse.is_only_warehouse', false);
        $this->migrator->add('warehouse.priority_warehouse', []);
        $this->migrator->add('warehouse.ignores_warehouse', []);
        $this->migrator->add('warehouse.sim_hidden', []);
        $this->migrator->add('warehouse.percent_rates', []);
        $this->migrator->add('warehouse.priority_price_min', null);
        $this->migrator->add('warehouse.priority_price_max', null);
        $this->migrator->add('warehouse.sort_default', 'random');

        $this->migrator->add('image.width_featured', 293);
        $this->migrator->add('image.height_featured', 158);
        $this->migrator->add('image.width_thumbnail', 190);
        $this->migrator->add('image.height_thumbnail', 117);
        $this->migrator->add('image.width_small', 101);
        $this->migrator->add('image.height_small', 70);
        $this->migrator->add('image.extension', 'webp');
    }

    public function down(): void
    {
        $this->migrator->delete('general.site_name');
        $this->migrator->delete('general.site_description');
        $this->migrator->delete('general.head_script_before');
        $this->migrator->delete('general.head_script_after');
        $this->migrator->delete('general.body_script_before');
        $this->migrator->delete('general.body_script_after');
        $this->migrator->delete('general.sim_limit');

        $this->migrator->delete('hotline.seller');
        $this->migrator->delete('hotline.zalo');
        $this->migrator->delete('hotline.phone');

        $this->migrator->delete('warehouse.sim_update_lt_days');
        $this->migrator->delete('warehouse.is_only_warehouse');
        $this->migrator->delete('warehouse.priority_warehouse');
        $this->migrator->delete('warehouse.ignores_warehouse');
        $this->migrator->delete('warehouse.sim_hidden');
        $this->migrator->delete('warehouse.percent_rates');
        $this->migrator->delete('warehouse.priority_price_min');
        $this->migrator->delete('warehouse.priority_price_max');
        $this->migrator->delete('warehouse.sort_default');

        $this->migrator->delete('image.width_featured');
        $this->migrator->delete('image.height_featured');
        $this->migrator->delete('image.width_thumbnail');
        $this->migrator->delete('image.height_thumbnail');
        $this->migrator->delete('image.width_small');
        $this->migrator->delete('image.height_small');
        $this->migrator->delete('image.extension');
    }
};
