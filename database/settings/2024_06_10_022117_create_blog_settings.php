<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('blog.title', 'Sim Thăng Long - Tin Sim Số Đẹp, Phong Thủy, Tử vi mới nhất');
        $this->migrator->add('blog.description', 'Sim Thăng Long - Blog chia sẻ tin tức sim số đẹp, sim data, gói cước, phong thủy sim, tử vi theo nhiều góc nhìn của chuyên gia');
        $this->migrator->add('blog.head_script_before', '');
        $this->migrator->add('blog.head_script_after', '');
        $this->migrator->add('blog.body_script_before', '');
        $this->migrator->add('blog.body_script_after', '');
        $this->migrator->add('blog.timezone', 'Asia/Ho_Chi_Minh');
        $this->migrator->add('blog.post_limit', 10);
    }

    public function down(): void
    {
        $this->migrator->delete('blog.title');
        $this->migrator->delete('blog.description');
        $this->migrator->delete('blog.head_script_before');
        $this->migrator->delete('blog.head_script_after');
        $this->migrator->delete('blog.body_script_before');
        $this->migrator->delete('blog.body_script_after');
        $this->migrator->delete('blog.timezone');
        $this->migrator->delete('blog.post_limit');
    }
};
