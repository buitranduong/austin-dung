<?php

namespace App\Models\Blog;

use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Models\User;
use App\Services\CacheModelService;
use App\Services\SitemapNewsService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements Feedable, Sitemapable
{
    use HasFactory, HasSlug, SoftDeletes, Searchable;

    protected $table = 'posts';
    protected $fillable = [
        'id',
        'slug',
        'title',
        'featured_image',
        'sticky',
        'excerpt',
        'content',
        'status',
        'type',
        'meta_data',
        'related_content',
        'head_script_before',
        'head_script_after',
        'body_script_before',
        'body_script_after',
        'published_at',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
       return [
           'title'=>$this->title,
           'content'=>$this->content,
       ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'meta_data' => AsArrayObject::class,
            'status' => PostStatus::class,
            'type' => PostType::class,
            'related_content'=>'array',
            'sticky' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
    public function next(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->where('id','!=', $this->id)
                ->where('published_at', '>=', $this->published_at)
                ->orderBy('published_at', 'asc')
                ->first(),
        );

    }
    public function previous(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->where('id','!=', $this->id)
                ->where('published_at', '<=', $this->published_at)
                ->orderBy('published_at', 'desc')
                ->first(),
        );
    }
    public function category(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->categories()->first(),
        );
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->doNotGenerateSlugsOnUpdate()
            ->saveSlugsTo('slug');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('status', PostStatus::Published);
    }

    public function scopeIsStatus(Builder $query, PostStatus $status): void
    {
        $query->where('status', $status);
    }

    public function scopeSticky(Builder $query): void
    {
        $query->where('sticky', 1);
    }
    public function scopeRelated(Builder $query, array $ignore=[], $take=3): void
    {
        if($ignore){
            $query->whereNotIn('posts.id', $ignore);
        }
        $query->published()->latest('published_at')->take($take);
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'post_of_category', 'post_id', 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_of_category', 'post_id', 'category_id');
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('post-page', function (Builder $builder) {
            $builder->where('type', PostType::Post);
        });

        static::creating(function (Post $post) {
            if(auth()->check()){
                $post->created_by = auth()->id();
                $post->updated_by = auth()->id();
            }
        });

        static::updating(function (Post $post) {
            if(auth()->check()){
                $post->updated_by = auth()->id();
            }
        });

        static::created(function (Post $post) {
           if($post->status == PostStatus::Published){
               if($post->tags->count()){
                   CacheModelService::setBlogTags();
               }
               CacheModelService::setBlogPostsLatest();
               CacheModelService::resetPostOfCategory();
               SitemapNewsService::generateToFile();
           }
        });

        static::updated(function (Post $post) {
            CacheModelService::setBlogPostsLatest();
            CacheModelService::setBlogTags();
            CacheModelService::resetPostOfCategory($post->category->slug);
            if($post->wasChanged(['status'])){
                SitemapNewsService::generateToFile();
            }
        });

        static::deleting(function (Post $post) {
            CacheModelService::resetPostOfCategory($post->category->slug);
        });

        static::deleted(function (Post $post) {
            CacheModelService::setBlogPostsLatest();
            CacheModelService::setBlogTags();
        });
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary(Str::of($this->content)->stripTags()->words())
            ->updated($this->published_at)
            ->link(blog_route('blog.post',[$this->slug]))
            ->image($this->featured_image ? asset("storage/$this->featured_image") : '')
            ->category($this->category->name ?? '')
            ->authorName($this->createdByUser->name)
            ->authorEmail($this->createdByUser->email);
    }

    public function toSitemapTag(): Url | string | array
    {
        $title = html_entity_decode($this->title, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
        if(!empty($this->featured_image)){
            return Url::create(blog_route('blog.post', [$this->slug]))
                ->setLastModificationDate(Carbon::create($this->published_at))
                ->addImage($this->featured_image ?? '', $title,'', $title);
        }
        return Url::create(blog_route('blog.post', [$this->slug]))
            ->setLastModificationDate(Carbon::create($this->published_at));
    }
}
