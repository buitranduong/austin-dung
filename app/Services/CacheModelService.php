<?php

namespace App\Services;

use App\Enums\PostStatus;
use App\Models\Blog\Category;
use App\Models\Blog\Post;
use App\Models\Blog\Tag;
use App\Models\Seller\CustomPrice;
use App\Models\Seller\SimOrders;
use App\Models\Seo\PageSeo;
use App\Models\Seo\SimSeo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CacheModelService
{
    public static function getLatestOrder()
    {
        return Cache::rememberForever('latestOrder', function (){
            return  SimOrders::latest()->take(5)->get(['name','phone','created_at','order_type']);
        });
    }
    public static function setLatestOrder(?Collection $orders = null)
    {
        Cache::forget('latestOrder');
        if($orders){
            return Cache::rememberForever('latestOrder', fn() => $orders);
        }
        return self::getLatestOrder();
    }
    public static function getCustomPrice()
    {
        return Cache::rememberForever('customPriceAll', function (){
            return CustomPrice::all();
        });
    }
    public static function setCustomPrice()
    {
        Cache::forget('customPriceAll');
        return self::getCustomPrice();
    }

    private static function getSimSeoFromCache(array $sim): ?SimSeo
    {
        // tim trong cache
        $rangePrice = Cache::tags(['simSeo'])->get('simSeo-rangePrice');
        if($rangePrice) {
            foreach ($rangePrice as $range) {
                foreach ($range as $type => $price) {
                    if((int)$type == (int)$sim['detail']['c2']) {
                        if (isset($price[0]) and isset($price[1])) {
                            if ($sim['detail']['pn'] >= $price[0] and $sim['detail']['pn'] <= $price[1]) {
                                $rangePriceKey = "simSeo-{$type}-{$price[0]}-{$price[1]}";
                                return Cache::tags(['simSeo'])->get($rangePriceKey);
                            }
                        }else{
                            if ($sim['detail']['pn'] >= $price[0]) {
                                $rangePriceKey = "simSeo-{$type}-{$price[0]}-{$price[1]}";
                                return Cache::tags(['simSeo'])->get($rangePriceKey);
                            }
                        }
                    }else{
                        if (isset($price[0]) and isset($price[1])) {
                            if ($sim['detail']['pn'] >= $price[0] and $sim['detail']['pn'] <= $price[1]) {
                                $rangePriceKey = "simSeo--{$price[0]}-{$price[1]}";
                                return Cache::tags(['simSeo'])->get($rangePriceKey);
                            }
                        }else{
                            if ($sim['detail']['pn'] >= $price[0]) {
                                $rangePriceKey = "simSeo--{$price[0]}-{$price[1]}";
                                return Cache::tags(['simSeo'])->get($rangePriceKey);
                            }
                        }
                    }
                }
            }
        }
        return null;
    }
    public static function getSimSeo(array &$sim): array
    {
        // tim trong cache
        $simSeo = self::getSimSeoFromCache($sim);
        if(!$simSeo){
            // Lay toan bo sim seo tao cache theo khoang gia
            $simSeoAll = SimSeo::orderByDesc('sim_type')->get();
            if($simSeoAll){
                $rangePrice = [];
                foreach ($simSeoAll as $item){
                    $rangePrice[][$item->sim_type] = [$item->price_min, $item->price_max];
                    Cache::tags(['simSeo'])->put("simSeo-{$item->sim_type}-{$item->price_min}-{$item->price_max}", $item);
                }
                if($rangePrice){
                    // Sap xep uu tien co sim type duoc ap dung truoc
                    $rangePrice = collect($rangePrice)->sort();
                    Cache::tags(['simSeo'])->put('simSeo-rangePrice', $rangePrice);
                }
            }
            $simSeo = self::getSimSeoFromCache($sim);
        }
        if($simSeo){
            $sim['title'] = replace_sim_seo($simSeo->title, $sim['detail']);
            $sim['description'] = replace_sim_seo($simSeo->description, $sim['detail']);
            $sim['h1'] = replace_sim_seo($simSeo->h1, $sim['detail']);
        }
        return $sim;
    }
    public static function forgetSimSeo(string $slug = null): void
    {
        if(!empty($slug)){
            Cache::forget("simSeo-{$slug}");
        }else{
            Cache::tags(['simSeo'])->flush();
        }
    }
    public static function getPageSeo(string $slug, array $seo_default)
    {
        $data = Cache::rememberForever("pageSeo-{$slug}", function () use($slug) {
            return PageSeo::findBySlug($slug)->published()->first();
        });
        if (!$data && count($seo_default)>0){
            $data = new PageSeo();
            $data->fill($seo_default);
        }
        return $data;
    }

    public static function setPageSeo(string $slug)
    {
        self::forgetPageSeo($slug);
        return self::getPageSeo($slug, []);
    }

    public static function forgetPageSeo(string $slug): bool
    {
        return Cache::forget("pageSeo-{$slug}");
    }

    public static function getBlogCategories(bool $featured = true)
    {
        return Cache::tags(['blogCategories'])->rememberForever("blogCategories-$featured", function () use ($featured) {
            $category = Category::published();
            if($featured){
                $category->featured();
            }
            return $category->get();
        });
    }

    public static function setBlogCategories(bool $featured = true)
    {
        Cache::forget("blogCategories-$featured");
        return self::getBlogCategories($featured);
    }

    public static function forgetBlogCategories(): void
    {
        Cache::tags(['blogCategories'])->flush();
    }

    public static function getPostOfCategory(string $slug)
    {
        return Cache::tags(['blogCategory', $slug])->rememberForever("blogCategory-$slug", function () use ($slug) {
            $category = Category::with(['posts' => function ($query) {
                $query->where('status', PostStatus::Published)
                    ->orderBy('published_at', 'desc')
                    ->take(5);
            }])
                ->published()
                ->where('slug', $slug)
                ->first();
            return  $category->posts ?? [];
        });
    }

    public static function resetPostOfCategory(?string $slug = null): void
    {
        if(!empty($slug)){
            Cache::tags([$slug])->flush();
        }else{
            Cache::tags(['blogCategory'])->flush();
        }
    }

    public static function setPostOfCategory(string $slug)
    {
        Cache::forget("blogCategory-$slug");
        return self::getPostOfCategory($slug);
    }

    public static function getBlogTags(bool $featured = true)
    {
        return Cache::tags(['blogTags'])->rememberForever("blogTags-$featured", function () use($featured) {
            $tags = Tag::withCount(['posts'=>function (Builder $query) {
                $query->where('status', PostStatus::Published);
            }]);
            if($featured){
                $tags = $tags->featured();
            }
            return $tags->get();
        });
    }

    public static function setBlogTags(bool $featured = true)
    {
        Cache::forget("blogTags-$featured");
        return self::getBlogTags($featured);
    }

    public static function forgetBlogTags(): void
    {
        Cache::tags(['blogTags'])->flush();
    }

    public static function getBlogPostsLatest()
    {
        return Cache::rememberForever("blogPostsLatest", function () {
            return Post::published()
                ->sticky()
                ->latest('published_at')
                ->take(5)
                ->get(['id','slug','title','featured_image','published_at']);
        });
    }

    public static function setBlogPostsLatest()
    {
        Cache::forget("blogPostsLatest");
        return self::getBlogPostsLatest();
    }
}
