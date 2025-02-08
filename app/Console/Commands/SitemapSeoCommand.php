<?php

namespace App\Console\Commands;

use App\Models\Seo\PageSeo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapSeoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:seo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command generate the sitemap seo page';

    /**
     * Execute the console command.
     * @throws \ReflectionException
     */
    public function handle()
    {
        $seoPages = PageSeo::published()->get(['slug','title','content','featured_image','published_at']);
        if($seoPages){
            $data = [];
            foreach($seoPages as $page){
                $title = html_entity_decode($page->title, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
                $url = Url::create(url($page->slug))
                    ->setLastModificationDate(Carbon::create($page->published_at));
                if($page->featured_image) {
                    $featured_image = Str::ltrim($page->featured_image, '/');
                    $url->addImage(asset("storage/$featured_image") ?? '', $title,'', $title);
                }
                if(!empty($page->content)) {
                    $images = extract_image_from_content($page->content);
                    if($images){
                        foreach ($images as $img) {
                            $url->addImage($img);
                        }
                    }
                }
                $data[] = $url;
                $this->line("Add #$page->slug to sitemap");
            }
            Sitemap::create()
                ->add($data)
                ->writeToFile(public_path("seo-sitemap.xml"));
            $this->info('Sitemap generated successfully.');
        }
    }
}
