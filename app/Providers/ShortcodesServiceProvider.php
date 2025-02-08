<?php

namespace App\Providers;

use App\Supports\Shortcode\BtnCopyTag;
use App\Supports\Shortcode\ListSimTag;
use Illuminate\Support\ServiceProvider;
use Webwizo\Shortcodes\Facades\Shortcode;

class ShortcodesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        Shortcode::register('custom_query', ListSimTag::class);
        Shortcode::register('btn_copy', BtnCopyTag::class);
    }
}
