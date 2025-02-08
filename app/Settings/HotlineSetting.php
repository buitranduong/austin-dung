<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class HotlineSetting extends Settings
{
    public string $seller;
    public string $zalo;
    public string $phone;
    public static function group(): string
    {
        return 'hotline';
    }

    public function fieldSet(): object
    {
        return (object)[
            'seller' => (object)[
                'text'=>__('Số điện thoại kinh doanh'),
                'icon'=>'<i class="bi bi-telephone-outbound"></i>',
            ],
            'zalo' => (object)[
                'text'=>__('Link chat group zalo'),
                'icon'=>'<i class="bi bi-link-45deg"></i>',
            ],
            'phone' => (object)[
                'text'=>__('Số hotline phản ánh'),
                'icon'=>'<i class="bi bi-telephone-inbound"></i>',
            ],
        ];
    }
}
