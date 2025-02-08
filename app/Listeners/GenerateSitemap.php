<?php

namespace App\Listeners;

use App\Events\PostPublished;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap
{
    /**
     * Create the event listener.
     */
    public function __construct(){}

    /**
     * Handle the event.
     */
    public function handle(PostPublished $event): void
    {
        $title = html_entity_decode($event->post->title, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
        $url = Url::create(blog_route('blog.post', [$event->post->slug]))
            ->setLastModificationDate(Carbon::create($event->post->published_at));
        if($event->post->featured_image) {
            $url->addImage(asset($event->post->featured_image) ?? '', $title,'', $title);
        }
        $images = extract_image_from_content($event->post->content);
        if($images){
            foreach ($images as $img) {
                $url->addImage($img);
            }
        }
        Sitemap::create()
            ->add($url)
            ->writeToFile(public_path("post-sitemap.xml"));
    }
}
