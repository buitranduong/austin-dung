<?php

namespace App\Services;

use App\Models\Seo\PageSeo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;

class CrawlDataService
{
    public static function crawlOut(string $url): array
    {
        $data = [];
        $response = Http::get($url);
        if($response->successful()) {
            $dom = new Dom;
            $dom->loadStr($response->body());
            $data['title'] = $dom->find('title')[0]->innerHtml ?? '';
            $data['description'] = $dom->getElementsByTag('meta[name="description"]')
                ->offsetGet(0)
                ->getAttribute('content');
            $data['h1'] = $dom->find('h1')[0]->innerHtml ?? '';
        }
        return $data;
    }

    public static function crawlIn(?string $url): PageSeo|null
    {
        $url = $url ?? '/';
        $slug = Str::of($url)->replace(url(''), '')->value();
        return CacheModelService::getPageSeo($slug, []);
    }
}
