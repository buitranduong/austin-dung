<?php

namespace App\Models\Seller;

use App\Enums\OrderType;
use App\Enums\PaymentType;
use App\Services\CacheModelService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SimOrders extends Model
{
    use HasUuids;

    protected $table = 'sim_orders';
    protected $fillable = [
        'sim',
        'amount',
        'telco_id',
        'phone',
        'name',
        'address',
        'other_option',
        'payment_method',
        'mst',
        'source_text',
        'order_type',
        'attributes',
        'pushed',
        'error',
        'logs',
        'ip',
        'browse_history',
        'created_at'
    ];

    protected $casts = [
        'payment_method'=>PaymentType::class,
        'order_type'=>OrderType::class,
        'browse_history' => 'array',
        'pushed'=>'boolean',
        'error'=>'boolean',
        'logs'=>'array',
        'attributes'=>'array'
    ];

    public function scopeSearch($query, $search): void
    {
        if(!empty($search)){
            $query->where(function ($query) use ($search) {
                $query->orWhere('sim', $search);
                $query->orWhere('name', 'ilike', '%'.$search.'%');
                $query->orWhere('phone', 'like', $search);
                $query->orWhere('ip', 'like', $search.'%');
            });
        }
    }

    public function scopeFilter($query, $filter): void
    {
        if(!empty($filter)){
            $query->where('telco_id', $filter);
        }
    }

    public function scopeIsPushed($query, bool $pushed): void
    {
        $query->where('pushed', $pushed);
    }

    public function scopeWithinTimeRange(Builder $query, $period)
    {
        switch ($period) {
            case '7_days':
                return $query->whereBetween('created_at', [Carbon::now()->subDays(6), Carbon::now()]);
                break;
            case '2_weeks':
                return $query->whereBetween('created_at', [Carbon::now()->subWeeks(2), Carbon::now()]);
                break;
            case '3_weeks':
                return $query->whereBetween('created_at', [Carbon::now()->subWeeks(3), Carbon::now()]);
                break;
            case '1_month':
                return $query->whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()]);
                break;
            case '3_month':
                return $query->whereBetween('created_at', [Carbon::now()->subMonth(3), Carbon::now()]);
                break;
            case '1_year':
                return $query->whereBetween('created_at', [Carbon::now()->subYear(), Carbon::now()]);
                break;
            default:
                return $query;
                break;
        }
    }

    protected static function booted(): void
    {
        static::created(function (SimOrders $model) {
            CacheModelService::setLatestOrder();
        });
    }
}
