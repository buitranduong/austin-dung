<?php

namespace App\Console\Commands;

use App\Models\Seo\PageSeo;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ReplaceDataSeoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replace:data-seo';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $seo_page = PageSeo::all(['id','content','related_content','featured_image']);
        foreach ($seo_page as $page) {
		$seo = PageSeo::find($page->id);
		$seo->featured_image = Str::replace(['https://prod.simthanglong.vn','https://simthanglong.vn','storage'],'', $seo->featured_image);
            $content = html_entity_decode($page->content);
            $seo->content = Str::replace(['https://prod.simthanglong.vn','https://simthanglong.vn'],'', $content);
            $seo->related_content = Str::replace(['https://prod.simthanglong.vn','https://simthanglong.vn'],'', $seo->related_content);
            $seo->saveQuietly();
            $this->line("Replaced data #$page->id successfully !");
        }
    }
}
