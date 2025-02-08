<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class BlogSetting extends Settings
{
    public string $title;
    public string $description;
    public string | null $head_script_before;
    public string | null $head_script_after;
    public string | null $body_script_before;
    public string | null $body_script_after;
    public string $timezone;
    public int $post_limit;
    public static function group(): string
    {
        return 'blog';
    }

    public function fieldSet(): object
    {
        return (object)[
            'title' => (object)[
                'text'=>__('Tiêu đề seo trang chủ'),
                'icon'=>'<i class="bi bi-globe-americas"></i>'
            ],
            'description' => (object)[
                'text'=>__('Giới thiệu seo trang chủ'),
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
            'timezone' => (object)[
                'text'=>__('Múi giờ'),
                'icon'=>'<i class="bi bi-clock"></i>'
            ],
            'post_limit' => (object)[
                'text'=>__('Số bài hiển thị trên trang'),
                'icon'=>'<i class="bi bi-grid-3x3"></i>'
            ],
        ];
    }
}
