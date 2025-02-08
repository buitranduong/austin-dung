<?php

namespace App\Models\Blog;

use App\Enums\CategoryType;
use App\Services\CacheModelService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model implements Sitemapable
{
    use HasFactory, HasSlug,SoftDeletes;

    protected $table = 'categories';
    protected $fillable = [
        'id',
        'slug',
        'name',
        'description',
        'featured_image',
        'featured',
        'published',
        'meta_data',
        'related_content',
        'head_script_before',
        'head_script_after',
        'body_script_before',
        'body_script_after',
        'type',
        'parent_id'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'meta_data' => AsArrayObject::class,
            'type' => 'string',
            'published' => 'boolean',
            'featured' => 'boolean'
        ];
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->doNotGenerateSlugsOnUpdate()
            ->saveSlugsTo('slug');
    }

    public function scopeRoot(Builder $query): void
    {
        $query->where('type', CategoryType::Category)
            ->whereNull('parent_id');
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('published', 1);
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('featured', 1);
    }

    public function scopeOf(Builder $query, CategoryType $type = CategoryType::Category): void
    {
        $query->where('type', $type);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            $category->type = CategoryType::Category;
            if(auth()->check()){
                $category->created_by = auth()->id();
                $category->updated_by = auth()->id();
            }
        });
        static::created(function () {
            CacheModelService::forgetBlogCategories();
        });
        static::updated(function () {
            CacheModelService::forgetBlogCategories();
        });
        static::deleted(function () {
            CacheModelService::forgetBlogCategories();
        });
        static::updating(function (Category $category) {
            if(auth()->check()){
                $category->updated_by = auth()->id();
            }
        });

        static::addGlobalScope('category-tag', function (Builder $builder) {
            $builder->where('type', CategoryType::Category);
        });
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }
    public function posts($skip_post_id=0)
    {
        if($skip_post_id > 0){
            return $this->belongsToMany(Post::class, 'post_of_category', 'category_id', 'post_id')->wherePivot('post_id', '!=',$skip_post_id);
        }
        return $this->belongsToMany(Post::class, 'post_of_category', 'category_id', 'post_id');
    }

    public function toSitemapTag(): Url | string | array
    {
        return Url::create(blog_route('blog.category', [$this->slug]))
            ->setLastModificationDate(Carbon::create($this->updated_at));
    }
}
