<?php

namespace App\Http\Controllers\Admin\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller\SimOrders;
use App\Services\SimService;
use App\Settings\OrderSetting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private array $listTel;

    /**
     * @name Quản lý đơn hàng
     */
    public function __construct(SimService $simService, private readonly OrderSetting $orderSetting)
    {
        $this->middleware('can:OrderController.index')->only(['index','detail','setting']);
        $this->listTel = $simService->getListTel()->toArray();
    }

    /**
     * @name Xem danh sách
     */
    public function index(Request $request)
    {
        $simOrders = SimOrders::search($request->get('q'))->filter($request->get('filter'))->WithinTimeRange($request->get('time'));
        if ($request->has('pushed')) {
            $pushed = filter_var($request->input('pushed'), FILTER_VALIDATE_BOOLEAN);
            $simOrders->isPushed($pushed);
        }
        $simOrders = $simOrders->orderBy('id', 'desc')->paginate();
        $listTel = $this->listTel;
        $order_setting = $this->orderSetting;
        return view('admin.seller.order.index', compact('simOrders','listTel','order_setting'));
    }

    public function detail($id)
    {
        $simOrder = SimOrders::findOrFail($id);
        $listTel = $this->listTel;
        return view('admin.seller.order.detail',compact('simOrder','listTel'));
    }

    public function rePush(Request $request, $id)
    {
        if($request->user()->hasRole('Super-Admin')) {
            $simOrder = SimOrders::findOrFail($id);
            $simOrder->pushed = false;
            $simOrder->error = false;
            $simOrder->save();
            // ghi log
            activity('SimOrders')
                ->causedBy($request->user())
                ->withProperties($simOrder)
                ->log('re-push order');
        }
        return redirect()->back();
    }

    public function setting(Request $request)
    {
        try{
            $this->orderSetting->black_phone = $request->textarea('black_phone');
            $this->orderSetting->black_ip = $request->textarea('black_ip');
            $this->orderSetting->save();
            return redirect()->back()->with(['message'=>__('Danh sách chặn đã được cập nhật')]);
        }catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['message'=>$e->getMessage()]);
        }
    }
}
