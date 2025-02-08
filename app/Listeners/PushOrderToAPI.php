<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PushOrderToAPI implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderCreated $event)
    {
        $order = $event->order;
        // $simDetail = $event->simDetail;
        $ord_attr = $order->attributes;
        $listUrls = array_merge(['SimThangLong.vn 221'], $order->browse_history ?? []);
        $message = $order->other_option ?? "";
        //$message .= "Giá kho: {$ord_attr['gia_goc']}, giá bán: {$ord_attr['gia_ban']}";

        // thong tin tra gop
        if (isset($ord_attr['so_tien_tra_truoc'])) {
            $message .= ", Trả trước: {$ord_attr['so_tien_tra_truoc']}";
            $message .= ", Tiền nợ: {$ord_attr['so_tien_no']}";
            $message .= ", Hàng tháng: {$ord_attr['so_tien_moi_thang']}";
            $message .= ", Kỳ hạn: {$ord_attr['ky_han']}tháng";
        }
        $orderData = array(
            "source"           => 'Website',
            "type_order"       => "default",
            "customer_name"    => $order->name,
            "customer_phone"   => $order->phone,
            "sold_product"     => $order->sim,
            "price"            => $order->amount,
            "customer_ip"      => $order->ip,
            "customer_address" => $order->address,
            "source_text"      => $order->source_text,
            "search_history"   => $listUrls,
            "request_client"   => $message,
            "other_option"     => $message,
            "request_date"     => $order->created_at->format('Y-m-d H:i:s'),
            "reference_url"    => "",
            "storeids" 		   => []
        );
        Log::error('Order pushed to TOPSIM INFO', ['response'=> $orderData]);
        // Send the order data to the API
        $topsim_base_api = config('constant.topsim_base_api');
        if(!empty($topsim_base_api)){
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post("$topsim_base_api/opportunities/bulk-create", [$orderData]);
            // data?.data?.status == 'success'
            if ($response->successful()) {
                $response_data = $response->json();
                $status = $response_data['status'];
                if($status=="success") {
                    // update pushed status
                    $order->pushed = true;
                    $order->save();
                }
            } elseif ($response->clientError()){
                $order->error = true;
                $order->logs = $response->json();
                Log::debug('Order pushed to TOPSIM ERROR1', ['response'=> $response->json(), 'order'=>$order]);
                $order->save();
            } else {
                Log::debug('Order pushed to TOPSIM ERROR2', ['response'=> $response->json(), 'order'=>$order]);
            }
        }
    }
}
