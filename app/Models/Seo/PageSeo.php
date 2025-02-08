<?php

namespace App\Models\Seo;

use App\Enums\PageStatus;
use App\Models\User;
use App\Services\CacheModelService;
use App\Supports\Schema\SchemaOffers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSeo extends Model
{
    // protected $connection = 'staging';
    protected $table = 'seo_pages';
    protected $fillable = [
        'slug',
        'title',
        'h2',
        'featured_image',
        'featured',
        'excerpt',
        'content',
        'status',
        'published_at',
        'meta_data',
        'related_content',
        'head_script_before',
        'head_script_after',
        'body_script_before',
        'body_script_after',
        'sim_setting',
        'faq',
        'schema_product'
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
            'sim_setting' => AsArrayObject::class,
            'related_content'=>'array',
            'faq' => AsArrayObject::class,
            'status' => PageStatus::class,
            'featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function schema(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => new SchemaOffers($attributes),
            set: fn (SchemaOffers $value) => [
                'min_price' => $value->minPrice,
                'max_price' => $value->maxPrice,
                'offer_count' => $value->offerCount,
            ],
        )->shouldCache();
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
        $query->where('status', PageStatus::Published);
    }

    public function scopeIsStatus(Builder $query, PageStatus $status): void
    {
        $query->where('status', $status);
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('featured', 1);
    }

    public function scopeFindBySlug(Builder $query, string $slug): void
    {
        $query->where('slug', $slug);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (PageSeo $model) {
            $model->created_by = auth()->id() ?? 1;
            $model->updated_by = auth()->id() ?? 1;
        });
        static::updating(function (PageSeo $model) {
            $model->updated_by = auth()->id();
        });
        static::created(function (PageSeo $model) {
            CacheModelService::setPageSeo($model->slug);
        });
        static::updated(function (PageSeo $model) {
            if($model->wasChanged('slug')){
                CacheModelService::forgetPageSeo($model->getOriginal('slug'));
            }
            CacheModelService::setPageSeo($model->slug);
        });
    }
}
