<?php

namespace App\Services;

use App\Models\Blog\Post;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapNewsService
{
    public static function generateToFile(): void
    {
        $posts = Post::published()
            ->whereDate('published_at', '>=', Carbon::now()->subDays(5))
            ->latest('published_at')
            ->get(['slug','published_at','title']);
        if($posts) {
            $data = [];
            foreach ($posts as $post) {
                $title = html_entity_decode($post->title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $data[] = Url::create(blog_route('blog.post', [$post->slug]))
                    ->setLastModificationDate(Carbon::create($post->published_at))
                    ->addNews(
                        'SimThangLong.vn',
                        'vi',
                        $title,
                        $post->published_at,
                    );
            }
            Sitemap::create()
                ->add($data)
                ->writeToFile(public_path("post-news-sitemap.xml"));
        }
    }
}
