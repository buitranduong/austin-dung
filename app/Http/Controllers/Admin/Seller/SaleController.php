<?php

namespace App\Http\Controllers\Admin\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller\CustomPrice;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * @name Quản lý giảm giá
     */
    public function __construct()
    {
        $this->middleware('can:SaleController.index');
        $this->middleware('can:SaleController.store')->only('store');
        $this->middleware('can:SaleController.update')->only('update');
        $this->middleware('can:SaleController.destroy')->only('destroy');
    }

    /**
     * @name Cho phép xem danh sách
     */
    public function index()
    {
        $custom_prices = CustomPrice::paginate();
        return view('admin.seller.sale.index', compact('custom_prices'));
    }

    /**
     * @name Cho phép thêm mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'price_from' => 'required|numeric|lt:price_to',
            'price_to' => 'required|numeric|gt:price_from',
            'percent'=>'required|numeric|min:-99|max:99',
        ]);
        $customPrice = new CustomPrice();
        $customPrice->fill($request->all());
        $customPrice->save();
        // ghi log
        activity('CustomPrice')
            ->causedBy($request->user())
            ->performedOn($customPrice)
            ->withProperties($request->except('_token'))
            ->log('created sale price');
        return redirect()->route('admin.seller.sale.index')->with(['message'=> __('Bản ghi đã được tạo')]);
    }

    /**
     * @name Cho phép chỉnh sửa
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'price_from' => 'required|numeric|lt:price_to',
            'price_to' => 'required|numeric|gt:price_from',
            'percent'=>'required|numeric',
        ]);
        $customPrice = CustomPrice::findOrFail($id);
        $customPrice->fill($request->all());
        $customPrice->save();
        // ghi log
        activity('CustomPrice')
            ->causedBy($request->user())
            ->performedOn($customPrice)
            ->withProperties($request->except('_token'))
            ->log('edit sale price');
        return redirect()->route('admin.seller.sale.index')->with(['message'=> __('Bản ghi đã được cập nhật')]);
    }

    /**
     * @name Cho phép xóa
     */
    public function destroy(Request $request, $id)
    {
        // ghi log
        activity('CustomPrice')
            ->causedBy($request->user())
            ->performedOn(CustomPrice::find($id))
            ->withProperties(['id'=>$id])
            ->log('delete sale price');
        CustomPrice::destroy($id);
        return redirect()->route('admin.seller.sale.index')->with(['message'=> __('Bản ghi đã được xóa')]);
    }
}
