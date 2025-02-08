<?php

namespace App\Http\Controllers\Admin\Seo;

use App\Enums\SimPrice;
use App\Http\Controllers\Controller;
use App\Models\Seo\SimSeo;
use App\Services\SimService;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    /**
     * @name Quản lý SEO chi tiết Sim
     */
    public function __construct(private readonly SimService $simService)
    {
        $this->middleware('can:MetaController.index');
        $this->middleware('can:MetaController.create')->only('create', 'store');
        $this->middleware('can:MetaController.edit')->only('update');
        $this->middleware('can:MetaController.destroy')->only('destroy');
    }

    /**
     * @name Cho phép xem danh sách
     */
    public function index(Request $request)
    {
        $seo_sims = SimSeo::where(function ($query) use ($request) {
            if($request->get('q')){
                $query->orWhere('title', 'ilike', '%'. $request->get('q') .'%');
                $query->orWhere('description', 'ilike', '%'. $request->get('q') .'%');
                $query->orWhere('h1', 'ilike', '%'. $request->get('q') .'%');
            }
        })->orderBy('id', 'desc')->paginate();
        return view('admin.seo.meta.index', compact('seo_sims'));
    }

    /**
     * @name Cho phép tạo mới
     */
    public function create()
    {
        $sim_types = $this->simService->getSimTypes();
        $sim_price_min = SimPrice::PRICE_MIN;
        $sim_price_max = SimPrice::PRICE_MAX;
        return view('admin.seo.meta.create', compact('sim_types', 'sim_price_min', 'sim_price_max'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'h1' => 'required|max:255',
            'price_min' => 'nullable|numeric',
            'price_max' => 'nullable|numeric|gt:price_min',
        ]);
        $seoSim = new SimSeo();
        $seoSim->fill($request->all());
        $seoSim->save();
        return redirect()->route('admin.seo.meta.index')->with(['message'=> __('Bản ghi đã được tạo')]);
    }

    /**
     * @name Cho phép chỉnh sửa
     */
    public function edit($id)
    {
        $seo_sim = SimSeo::findOrFail($id);
        $sim_types = $this->simService->getSimTypes();
        $sim_price_min = SimPrice::PRICE_MIN;
        $sim_price_max = SimPrice::PRICE_MAX;
        return view('admin.seo.meta.edit', compact('seo_sim','sim_types', 'sim_price_min', 'sim_price_max'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'h1' => 'required|max:255',
            'price_min' => 'nullable|numeric',
            'price_max' => 'nullable|numeric|gt:price_min',
        ]);
        $seoSim = SimSeo::findOrFail($id);
        $seoSim->fill($request->all());
        $seoSim->save();
        return redirect()->route('admin.seo.meta.index')->with(['message'=> __('Bản ghi đã được cập nhật')]);
    }

    /**
     * @name Cho phép xóa
     */
    public function destroy($id)
    {
        SimSeo::destroy($id);
        return redirect()->route('admin.seo.meta.index')->with(['message'=> __('Bản ghi đã được xóa')]);
    }
}
