<?php

namespace App\Models\Seo;

use App\Services\CacheModelService;
use App\Services\SimService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SimSeo extends Model
{
    protected $table = 'seo_sims';
    protected $fillable = [
        'sim_type',
        'price_min',
        'price_max',
        'title',
        'description',
        'h1'
    ];
    public $timestamps = false;

    /**
     * Get the user's first name.
     */
    protected function simTypeName(): Attribute
    {
        return Attribute::make(
            get: function () {
                $simTypes = SimService::getSimTypes();
                return $simTypes->firstWhere('id', $this->sim_type);
            },
        );
    }

    public function scopePriceOf(Builder $query, int $price): void
    {
        $query
            ->where('price_min', '<=', $price)
            ->where(function ($filter) use($price) {
                $filter->orWhere('price_max', '>=', $price);
                $filter->orWhereNull('price_max');
            });
    }

    public function scopeSimTypeOf(Builder $query, array $simType): void
    {
        $query->whereIn('sim_type', $simType);
    }

    public function scopeApplyAll(Builder $query): void
    {
        $query->whereNull('sim_type')
            ->where('price_min', 0)
            ->whereNull('price_max');
    }

    protected static function booted(): void
    {
        static::updated(function (SimSeo $model) {
            if($model->wasChanged()){
                CacheModelService::forgetSimSeo();
            }
        });
        static::deleted(function (SimSeo $model) {
            CacheModelService::forgetSimSeo($model->sim_type);
        });
    }
}
