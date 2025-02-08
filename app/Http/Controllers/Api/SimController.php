<?php

namespace App\Http\Controllers\Api;

//use App\Events\OrderCreated;
use App\Models\Seller\SimOrders;
use App\Settings\WarehouseSetting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SimController extends BaseController
{
    public function pushOrderJobAPI()
    {
        $orders = SimOrders::where([
            'pushed'=>false,
            'error'=>false
        ])->get();
        foreach ($orders as $order) {
            //event(new OrderCreated($order));
            $this->process($order);
        }
        return response()->json(['status'=> 'success']);
    }

    private function process(SimOrders $order)
    {
        $ord_attr = $order->attributes;
        $browse_history = $order->browse_history ?? [];
        $store_ids = array_pop($browse_history);
        $listUrls = array_merge(['SimThangLong.vn 221'], $browse_history);
        $message = $order->other_option ?? "";
        //$message .= "Giá kho: {$ord_attr['gia_goc']}, giá bán: {$ord_attr['gia_ban']}";

        // thong tin tra gop
        if (isset($ord_attr['so_tien_tra_truoc'])) {
            $message .= ", Trả trước: {$ord_attr['so_tien_tra_truoc']}";
            $message .= ", Tiền nợ: {$ord_attr['so_tien_no']}";
            $message .= ", Hàng tháng: {$ord_attr['so_tien_moi_thang']}";
            $message .= ", Kỳ hạn: {$ord_attr['ky_han']}tháng";
        }
        $is_troll = false;
        $troll_reason = '';
        if(in_array('Is_Troll:1', $listUrls)) {
            $is_troll = true;
            $result = array_filter($listUrls, function ($value) {
                return str_starts_with($value, 'Troll_Reason');
            });
            $troll_reason = Arr::join($result, "\n");
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
            "is_troll"         => $is_troll,
            "troll_reason"     => $troll_reason,
            "storeids" 		   => json_decode($store_ids)
        );
        Log::error('Order pushed to TOPSIM INFO', ['response'=> $orderData]);
        // Send the order data to the API
        $topsim_base_api = config('constant.topsim_base_api');
        if(!empty($topsim_base_api)){
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->timeout(60)->post("$topsim_base_api/opportunities/bulk-create", [$orderData]);
            // data?.data?.status == 'success'
            if ($response->successful()) {
                $response_data = $response->json();
                $status = $response_data['status'];
                if($status=="success") {
                    // update pushed status
                    $order->pushed = true;
                    $order->save();
                    $this->tele($order);
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

    public function tele(SimOrders $order)
    {
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

    public function webhookWarehousePriority(Request $request, WarehouseSetting $warehouseSetting)
    {
        if($request->input('token') == 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9')
        {
            try {
                $warehouseSetting->priority_warehouse = $request->input('priority_warehouse');
                $warehouseSetting->save();
                return response()->json(['message'=>'The data has been updated successfully']);
            }catch (\Exception $exception){
                return response()->json(['message'=>$exception->getMessage()], $exception->getCode());
            }
        }
        return response()->json(['message'=>'Token not match'], 403);
    }

    public function webhookWarehouseIgnores(Request $request, WarehouseSetting $warehouseSetting)
    {
        if($request->input('token') == 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9')
        {
            try {
                $warehouseSetting->ignores_warehouse = $request->input('ignores_warehouse');
                $warehouseSetting->save();
                return response()->json(['message'=>'The data has been updated successfully']);
            }catch (\Exception $exception){
                return response()->json(['message'=>$exception->getMessage()], $exception->getCode());
            }
        }
        return response()->json(['message'=>'Token not match'], 403);
    }
}
