<?php

namespace App\Utils;

use App\Services\ScriptTagService;
use App\Settings\BlogSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class BlogMetaData extends Arr
{
    private array $collection;
    private BlogSetting $blogSetting;
    public function __construct(?Model $model)
    {
        $this->collection = [];
        if($model && method_exists($model, 'toArray')) {
            $this->collection = $model->toArray();
        }
        $this->blogSetting = app(BlogSetting::class);
    }

    public function getMetaData()
    {
        return self::get($this->collection, 'meta_data');
    }

    public function getMetaTitle()
    {
        return self::get($this->getMetaData(), 'title') ?? $this->blogSetting->title;
    }

    public function getMetaDescription()
    {
        return self::get($this->getMetaData(), 'meta.description') ?? $this->blogSetting->description;
    }

    public function getMetaKeywords()
    {
        return self::get($this->getMetaData(), 'meta.keywords')  ?? config('meta_tags.keywords.default');
    }

    public function getFeaturedImage(): ?string
    {
        $featured_image = self::get($this->collection, 'featured_image');
        if(!empty($featured_image)) {
            $featured_image = Str::replace('storage/', '', $featured_image);
            $featured_image = Str::ltrim($featured_image, '/');
        }
        return $featured_image;
    }

    public function getScriptPlacements(): array
    {
        return [
            new ScriptTagService(
                $this->blogSetting->head_script_before.self::get($this->collection, 'head_script_before', ''),
                'head_script_before'
            ),
            new ScriptTagService(
                $this->blogSetting->head_script_after.self::get($this->collection, 'head_script_after'),
                'head_script_after'
            ),
            new ScriptTagService(
                $this->blogSetting->body_script_before.self::get($this->collection, 'body_script_before'),
                'body_script_before'
            ),
            new ScriptTagService(
                $this->blogSetting->body_script_after.self::get($this->collection, 'body_script_after'),
                'body_script_after'
            )
        ];
    }
}
