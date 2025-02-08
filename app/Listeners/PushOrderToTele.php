<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PushOrderToTele implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderCreated $event)
    {
        $order = $event->order;
        $ord_attr = $order->attributes;
        //$listUrls = array_merge(['SimThangLong.vn 221'], $order->browse_history ?? []);
        // limit string
        $sim = Str::limit($order->sim, 6);
        $phone = Str::limit($order->phone, 6);
        $message = "Đơn hàng mới:";
        $message .= "\nKhách hàng: {$order->name}";
        $message .= "\nSản phẩm: {$sim}";
        $message .= "\nSĐT: {$phone}";
        $message .= "\nGiá tiền: {$order->amount}(Kho:{$ord_attr['gia_goc']})";
        $message .= "\nKiểu: {$order->order_type->value}";

        $orderData = [
            "id" => '-4208574394',
            "message"=> $message
        ];
        // Send the order data to the API
        $tele_push_api = config('constant.tele_push_api');
        if(!empty($tele_push_api)) {
            $response = Http::post("$tele_push_api", $orderData);
            if (!$response->successful()) {
                Log::debug('Order pushed to TELE ERROR', ['order' => $order]);
            }
        }
    }
}
