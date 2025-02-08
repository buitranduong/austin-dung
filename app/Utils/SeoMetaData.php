<?php

namespace App\Utils;

use App\Services\ScriptTagService;
use App\Settings\GeneralSetting;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SeoMetaData extends Arr
{
    private array $collection;
    private GeneralSetting $generalSetting;
    public function __construct(?Model $model, protected MetaInterface $meta)
    {
        $this->collection = [];
        if($model && method_exists($model, 'toArray')) {
            $this->collection = $model->toArray();
        }
        $this->generalSetting = app(GeneralSetting::class);
    }

    public function getMetaData()
    {
        return self::get($this->collection, 'meta_data');
    }

    public function getMetaTitle()
    {
        return self::get($this->getMetaData(), 'title') ?? $this->generalSetting->site_name;
    }

    public function getMetaDescription()
    {
        return self::get($this->getMetaData(), 'meta.description') ?? $this->generalSetting->site_description;
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
        $head_script_before = $this->meta->placement('head_script_before')->toHtml();
        $head_script_after = $this->meta->placement('head_script_after')->toHtml();
        $body_script_before = $this->meta->placement('body_script_before')->toHtml();
        $body_script_after = $this->meta->placement('body_script_after')->toHtml();
        return [
            new ScriptTagService(
                $head_script_before.self::get($this->collection, 'head_script_before'),
                'head_script_before'
            ),
            new ScriptTagService(
                $head_script_after.self::get($this->collection, 'head_script_after'),
                'head_script_after'
            ),
            new ScriptTagService(
                $body_script_before.self::get($this->collection, 'body_script_before'),
                'body_script_before'
            ),
            new ScriptTagService(
                $body_script_after.self::get($this->collection, 'body_script_after'),
                'body_script_after'
            )
        ];
    }
}
