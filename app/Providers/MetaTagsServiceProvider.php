<?php

namespace App\Providers;

use App\Utils\DetectAgent;
use Butschster\Head\Facades\PackageManager;
use Butschster\Head\MetaTags\Meta;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\Contracts\Packages\ManagerInterface;
use Butschster\Head\Packages\Package;
use Butschster\Head\Providers\MetaTagsApplicationServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Cookie;

class MetaTagsServiceProvider extends ServiceProvider
{
    private const VER = '1.1.0';
    protected function packages(): void
    {
        $path = 'static/theme';
        if(Cookie::get('AB_cookie', 'original') != 'original'){
            //$path .= '/'.Cookie::get('AB_cookie');
        }
        $secure = true;
        if(!in_array(config('app.env'), ['production','staging'])) {
            $secure = request()->secure();
        }
        PackageManager::create('styles', function(Package $package) use($secure, $path) {
            $package->addStyle(
                'styles.css',
                asset($path.'/css/styles.min.css?v='.self::VER, $secure),
            );
//            $package->addStyle(
//                'advance-filter.css',
//                asset($path.'/css/advance-filter.css?v='.self::VER, $secure),
//            );
//            $package->addStyle(
//                'faq.css',
//                asset($path.'/css/faq.min.css?v='.self::VER, $secure),
//            );
//            $package->addStyle(
//                'fix_list_sim.css',
//                asset($path.'/css/fix_list_sim.min.css?v='.self::VER, $secure),
//            );
        });

        PackageManager::create('homepage', function(Package $package) use($secure, $path) {
            $package->requires('styles');
            $package->addStyle(
                'homepage.css',
                asset($path.'/css/homepage.min.css?v='.self::VER, $secure),
            );
        });

        PackageManager::create('sim_detail', function(Package $package) use($secure, $path) {
            $package->requires('styles');
            $package->addStyle(
                'fix_sim_order.css',
                asset($path.'/css/fix_sim_order.min.css?v='.self::VER, $secure),
            );
            $package->addStyle(
                'sim_detail.css',
                asset($path.'/css/sim_detail.min.css?v='.self::VER, $secure),
            );
        });

        PackageManager::create('thu-mua-sim', function(Package $package) use($secure, $path) {
            $package->requires('styles');
            $package->addStyle(
                'thu-mua-sim.css',
                asset($path.'/css/thu-mua-sim.min.css?v='.self::VER, $secure),
            );
        });

        PackageManager::create('sim-phong-thuy', function(Package $package) use($secure, $path) {
            $package->addLink('form-phongthuy',['rel'=>'preload','as'=>'image','href'=>asset($path.'/images/phongthuy/form-phongthuy.png')]);
            $package->requires('styles');
            $package->addStyle(
                'sim_phong_thuy.css',
                asset($path.'/css/sim_phong_thuy.min.css?v='.self::VER, $secure),
            );
            $package->addStyle(
                'fix_sim_phong_thuy.css',
                asset($path.'/css/fix_sim_phong_thuy.css?v='.self::VER, $secure),
            );
        });

        PackageManager::create('news', function(Package $package) use($secure, $path) {
            $package->requires('styles');
            $package->addStyle(
                'news.css',
                asset($path.'/css/news.min.css?v='.self::VER, $secure),
            );
            $package->addStyle(
                'fix_news.css',
                asset($path.'/css/fix_news.min.css?v='.self::VER, $secure),
            );
            $package->addScript(
                'common.js',
                asset($path.'/js/common.min.js?v='.self::VER, $secure),
                [
                    'defer' => true,
                    'type' => 'text/javascript',
                ],
                'body_script_after'
            );
            $package->addScript(
                'search-keyword.js',
                asset($path.'/js/search-keyword.js?v='.self::VER, $secure),
                [
                    'defer' => true,
                    'type' => 'text/javascript',
                ],
                'body_script_after'
            );
            $package->addStyle(
                'toc.css',
                asset($path.'/css/toc.min.css?v='.self::VER, $secure),
            );
            $package->addScript(
                'toc.js',
                asset($path.'/js/toc.min.js?v='.self::VER, $secure),
                [
                    'defer' => true,
                    'type' => 'text/javascript',
                ],
                'body_script_after'
            );
        });

        PackageManager::create('common', function(Package $package) use($secure, $path) {
            $package->addScript(
                'common.js',
                asset($path.'/js/common.min.js?v='.self::VER, $secure),
                [
                    'defer' => true,
                    'type' => 'text/javascript',
                ],
                'body_script_after'
            );
            $package->addScript(
                'search-keyword.js',
                asset($path.'/js/search-keyword.js?v='.self::VER, $secure),
                [
                    'defer' => true,
                    'type' => 'text/javascript',
                ],
                'body_script_after'
            );
            $package->addScript(
                'browser-history.js',
                asset($path.'/js/browser-history.min.js?v='.self::VER, $secure),
                [
                    'defer' => true,
                    'type' => 'text/javascript',
                ],
                'body_script_after'
            );
            $package->addScript(
                'advance-search.js',
                asset($path.'/js/advance-search.js?v='.self::VER, $secure),
                [
                    'defer' => true,
                    'type' => 'text/javascript',
                ],
                'body_script_after'
            );
            $package->addScript(
                'faq.js',
                asset($path.'/js/faq.min.js?v='.self::VER, $secure),
                [
                    'defer' => true,
                    'type' => 'text/javascript',
                ],
                'body_script_after'
            );
        });

        PackageManager::create('category', function(Package $package) use($secure, $path) {
            $package->requires('common');
            $package->addScript(
                'category.js',
                asset($path.'/js/category.js?v='.self::VER, $secure),
                [
                    'defer' => true,
                    'type' => 'text/javascript',
                ],
                'body_script_after'
            );
        });

        PackageManager::create('valuation', function(Package $package) use($secure, $path) {
            $package->requires('common');
            $package->addStyle(
                'valuation.css',
                asset($path.'/css/valuation.min.css?v='.self::VER, $secure),
            );
            $package->addScript(
                'valuation.js',
                asset($path.'/js/valuation.min.js?v='.self::VER, $secure),
                [
                    'defer' => true,
                    'type' => 'text/javascript',
                ],
                'body_script_after'
            );
        });

        PackageManager::create('detail', function(Package $package) use($secure, $path) {
            $package->requires('common');
//            $package->addScript(
//                'detail.js',
//                asset($path.'/js/detail.js?v='.self::VER, $secure),
//                [
//                    'defer' => true,
//                    'type' => 'text/javascript',
//                ],
//                'body_script_after'
//            );
        });

        PackageManager::create('order-success', function(Package $package) use($secure, $path) {
            $package->requires('detail');
            $package->addScript(
                'browser-history.js',
                asset($path.'/js/clear-history.js?v='.self::VER, $secure),
                [
                    'defer' => true,
                    'type' => 'text/javascript',
                ],
                'body_script_after'
            );
        });
    }

    // if you don't want to change anything in this method just remove it
    protected function registerMeta(): void
    {
        $this->app->singleton(MetaInterface::class, function () {
            $meta = new Meta(
                $this->app[ManagerInterface::class],
                $this->app['config']
            );

            // It just an imagination, you can automatically
            // add favicon if it exists
            if (file_exists(public_path('favicon.ico'))) {
                $meta->setFavicon('/favicon.ico');
            }

            // This method gets default values from config and creates tags, includes default packages, e.t.c
            // If you don't want to use default values just remove it.
            $meta->initialize();

            return $meta;
        });
    }
}
