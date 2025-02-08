<?php

namespace App\Console\Commands;

use App\Enums\OrderType;
use App\Models\Seller\SimOrders;
use App\Services\CacheModelService;
use App\Utils\FakerVietnamese;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class OrderRandomCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:random';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed order random every ten minutes';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // random
        if(FakerVietnamese::boolean()){
            // lay danh sach orders tu cache
            $orders = CacheModelService::getLatestOrder();
            if(method_exists($orders, 'pop')){
                if($orders->count() >= 5){
                    // xoa order cuoi cung
                    $orders->pop();
                }
                // tao thong tin order moi
                $order = new SimOrders([
                    'name' => FakerVietnamese::fullName(rand(2,4)),
                    'phone' => FakerVietnamese::mobilePhone(),
                    'order_type' => FakerVietnamese::boolean() ? OrderType::COMMON : OrderType::INSTALLMENT,
                    'created_at' => now(),
                ]);
                // ghi don hang ao vao cache
                $orders->prepend($order);
                CacheModelService::setLatestOrder($orders);
                $this->info('Created fake order successful');
            }
        }
    }
}
