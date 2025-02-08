<?php

namespace App\Http\Controllers\Admin\Seller;

use App\Enums\SimProviders;
use App\Enums\SimSortDefault;
use App\Http\Controllers\Controller;
use App\Settings\WarehouseSetting;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * @name Cài đặt kho
     */
    public function __construct(private readonly WarehouseSetting $warehouseSetting)
    {
        $this->middleware('can:WarehouseController.index');
        $this->middleware('can:WarehouseController.update')->only('update');
    }

    /**
     * @name Cho phép xem
     */
    public function index()
    {
        $sim_providers = SimProviders::values();
        $sim_sort_default = SimSortDefault::array();
        $warehouse_setting = $this->warehouseSetting;
        return view('admin.seller.warehouse.index', compact('sim_providers','sim_sort_default','warehouse_setting'));
    }

    /**
     * @name Cho phép chỉnh sửa
     */
    public function update(Request $request)
    {
        $request->validate([
            'percent_rates.*'=>'nullable|integer|min:0',
            'filter_percent_rates.*'=>'nullable|integer|min:0',
            'priority_price_min'=>'nullable|integer|min:0|lt:priority_price_max',
            'priority_price_max'=>'nullable|integer|gt:priority_price_min',
        ]);
        $percent_rates = $request->input('percent_rates');
        $total = array_sum($percent_rates);
        if($total > 100 || $total < 0) {
            return redirect()->back()->withErrors(['percent_rates'=>__('Tổng tỉ lệ không đúng')]);
        }
        $filter_percent_rates = $request->input('filter_percent_rates');
        $total = array_sum($filter_percent_rates);
        if($total > 100 || $total < 0) {
            return redirect()->back()->withErrors(['filter_percent_rates'=>__('Tổng tỉ lệ không đúng')]);
        }
        $this->warehouseSetting->sim_update_lt_days = $request->input('sim_update_lt_days');
        $this->warehouseSetting->is_only_warehouse  = $request->checkbox('is_only_warehouse');
        $this->warehouseSetting->priority_warehouse = $request->textarea('priority_warehouse');
        $this->warehouseSetting->ignores_warehouse  = $request->textarea('ignores_warehouse');
        $this->warehouseSetting->sim_hidden         = $request->textarea('sim_hidden');
        $this->warehouseSetting->percent_rates      = $percent_rates;
        $this->warehouseSetting->filter_percent_rates = $filter_percent_rates;
        $this->warehouseSetting->priority_price_min = $request->input('priority_price_min');
        $this->warehouseSetting->priority_price_max = $request->input('priority_price_max');
        $this->warehouseSetting->sort_default       = $request->input('sort_default');
        $this->warehouseSetting->save();
        // ghi log
        activity('WarehouseSetting')
            ->causedBy($request->user())
            ->withProperties($request->except('_token'))
            ->log('edit sale price');
        return redirect()->back()->with(['message'=>__('Cấu hình đã được lưu')]);
    }
}
