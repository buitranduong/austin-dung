<?php

namespace App\Models\Seller;

use App\Services\CacheModelService;
use Illuminate\Database\Eloquent\Model;

class CustomPrice extends Model
{
    protected $table = 'custom_prices';
    protected $fillable = [
        'price_from',
        'price_to',
        'percent'
    ];

    protected $casts = [
        'percent' => 'float',
    ];

    public $timestamps = null;
    protected static function booted(): void
    {
        static::created(function (CustomPrice $model) {
            CacheModelService::setCustomPrice();
        });
        static::updated(function (CustomPrice $model) {
            if($model->wasChanged()){
                CacheModelService::setCustomPrice();
            }
        });
        static::deleted(function (CustomPrice $model) {
            CacheModelService::setCustomPrice();
        });
    }
}
