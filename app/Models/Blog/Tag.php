<?php

namespace App\Models\Blog;

use App\Enums\CategoryType;
use App\Services\CacheModelService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sitemap\Tags\Url;

class Tag extends Category
{
    use SoftDeletes;
    protected static function booted(): void
    {
        parent::booted();
        static::creating(function (Tag $tag) {
            $tag->type = CategoryType::Tags;
            $tag->created_by = auth()->id();
            $tag->updated_by = auth()->id();
        });
        static::created(function () {
            CacheModelService::forgetBlogTags();
        });
        static::updated(function () {
            CacheModelService::forgetBlogTags();
        });
        static::deleted(function () {
            CacheModelService::forgetBlogTags();
        });
        static::addGlobalScope('category-tag', function (Builder $builder) {
            $builder->where('type', CategoryType::Tags);
        });
    }

    public function toSitemapTag(): Url | string | array
    {
        return Url::create(blog_route('blog.tag', [$this->slug]))
            ->setLastModificationDate(Carbon::create($this->updated_at));
    }
}
