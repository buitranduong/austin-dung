<?php

namespace App\Events;

use App\Models\Seller\SimOrders;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCreated
{
    use Dispatchable, SerializesModels;

    /**
     * The created order.
     *
     * @var \App\Models\Seller\SimOrders
     */
    public $order;
    // public $simDetail;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Seller\SimOrders  $order
     * @return void
     */
    public function __construct(SimOrders $order)
    {
        $this->order = $order;
        // $this->simDetail = $simDetail;        
    }
}
