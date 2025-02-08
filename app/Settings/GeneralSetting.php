<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSetting extends Settings
{
    public string $site_name;
    public string $site_description;
    public string | null $head_script_before;
    public string | null $head_script_after;
    public string | null $body_script_before;
    public string | null $body_script_after;
    public int $sim_limit;
    public static function group(): string
    {
        return 'general';
    }

    public function fieldSet(): object
    {
        return (object)[
            'site_name' => (object)[
                'text'=>__('Tên website'),
                'icon'=>'<i class="bi bi-globe-americas"></i>'
            ],
            'site_description' => (object)[
                'text'=>__('Giới thiệu website'),
                'textarea'=>true,
            ],
            'head_script_before' => (object)[
                'text'=>__('Head script before'),
                'textarea'=>true,
            ],
            'head_script_after' => (object)[
                'text'=>__('Head script after'),
                'textarea'=>true,
            ],
            'body_script_before' => (object)[
                'text'=>__('Body script before'),
                'textarea'=>true,
            ],
            'body_script_after' => (object)[
                'text'=>__('Body script after'),
                'textarea'=>true,
            ],
            'sim_limit' => (object)[
                'text'=>__('Số sim hiển thị trên trang'),
                'icon'=>'<i class="bi bi-grid-3x3-gap"></i>'
            ],
        ];
    }
}
