<?php

namespace App\Http\Controllers\Admin\Seo;

use App\Enums\PageStatus;
use App\Enums\SimSortDefault;
use App\Http\Controllers\Controller;
use App\Models\Seo\PageSeo;
use App\Services\EnsureFolderUploadService;
use App\Services\ImageConvertService;
use App\Services\SimService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SeoController extends Controller
{
    /**
     * @name Quản lý Quản lý SEO page sim
     */
    public function __construct()
    {
        $this->middleware('can:SeoController.index');
        $this->middleware('can:SeoController.create')->only('create', 'store', 'upload');
        $this->middleware('can:SeoController.edit')->only('update', 'active', 'upload');
        $this->middleware('can:SeoController.destroy')->only('destroy');
        $this->middleware('can:SeoController.seoMeta')->only('seoMeta');
        $this->middleware('can:SeoController.simSetting')->only('simSetting');
    }

    /**
     * @name Cho phép xem danh sách
     */
    public function index(Request $request)
    {
        $seoPages = PageSeo::where(function ($query) use ($request) {
            if ($request->get('q')) {
                $query->where('title', 'ilike', '%' . $request->get('q') . '%')
                    ->orWhere('slug', 'ilike', '%' . $request->get('q') . '%');;
            }
        })->orderBy('created_at', 'desc')->paginate();
        return view('admin.seo.page.index', compact('seoPages'));
    }

    /**
     * @name Cho phép tạo mới
     */
    public function create()
    {
        $status = PageStatus::array();
        return view('admin.seo.page.create', compact('status'));
    }

    public function store(Request $request, ImageConvertService $imageConvertService)
    {
        $request->validate([
            'title' => 'required|max:255',
            'h2' => 'required|max:255',
            'slug' => 'required|unique:seo_pages,slug',
        ]);
        $pageSeo = new PageSeo();
        $pageSeo->meta_data = [
            'title' => $request->input('title'),
            'meta' => [
                'description' => strip_tags($request->input('excerpt')),
            ]
        ];
        $this->_fillDataToSave($pageSeo, $request, $imageConvertService);
        $pageSeo->related_content = $request->textarea('related_content');
        $pageSeo->save();
        return redirect()->route('admin.seo.page.edit', [$pageSeo->id])->with(['message' => __('Bản ghi đã được tạo')]);
    }

    public function active(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', PageStatus::values()),
        ]);
        $user = PageSeo::findOrFail($id);
        $user->status = $request->input('status');
        $user->save();
        return redirect()->route('admin.seo.page.index')->with(['message' => __('Bản ghi đã cập nhật')]);
    }

    /**
     * @name Cho phép sửa
     */
    public function edit(SimService $simService, $id)
    {
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        if ($route === 'admin.post.edit') {
            session(['previous_url' => $url]);
        }
        $page = PageSeo::findOrFail($id);
        $meta_data = [];
        if ($page->meta_data && method_exists($page->meta_data, 'toArray')) {
            $meta_data = $page->meta_data->toArray();
        }
        $sim_setting = [];
        if ($page->sim_setting && method_exists($page->sim_setting, 'toArray')) {
            $sim_setting = $page->sim_setting->toArray();
        }
        $sorts = SimSortDefault::array();
        $providers = $simService->getListTel();
        $status = PageStatus::array();
        return view('admin.seo.page.edit', compact('page', 'status', 'meta_data', 'sim_setting', 'sorts', 'providers'));
    }

    public function update(Request $request, ImageConvertService $imageConvertService, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'h2' => 'required|max:255',
            'slug' => 'required|unique:seo_pages,slug,' . $id,
        ]);
        $pageSeo = PageSeo::findOrFail($id);
        $this->_fillDataToSave($pageSeo, $request, $imageConvertService);
        return redirect()->route('admin.seo.page.edit',[$pageSeo->id])->with(['message' => __('Bản ghi đã được tạo')]);
    }

    public function upload(Request $request, ImageConvertService $imageConvertService)
    {
        $request->validate([
            'file' => 'required|image|max:2048'
        ]);
        if ($request->file('file')->isValid()) {
            try {
                $file = $request->file('file');
                $filePath = $file->store('public/tmp');
                if ($filePath) {
                    $destinationPath = EnsureFolderUploadService::makeFolder(storage_path('app/public/uploads'));
                    $location = $imageConvertService->fromFile($file)
                        ->fromPath(storage_path("app/{$filePath}"))
                        ->convertFitSize($destinationPath);
                    $location = str_replace(storage_path('app/public'), url('storage'), $location);
                    return response()->json(['location' => $location, 'link' => url('storage')]);
                }
            } catch (\Exception $exception) {
                return response()->json(['message' => $exception->getMessage()], 500);
            }
        }

        return response()->json(['message' => 'File is invalid'], 500);
    }

    private function _fillDataToSave(&$pageSeo, $request, ImageConvertService $imageConvertService): void
    {
        $pageSeo->fill($request->except(['featured', 'featured_image']));
        $pageSeo->featured = $request->checkbox('featured');
        if ($request->hasFile('featured_image') && $request->file('featured_image')->isValid()) {
            $file = $request->file('featured_image');
            $filename = $file->getClientOriginalName();
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
            $filename = Str::of($filename)->basename(".{$fileExtension}")->slug();
            $destinationPath = EnsureFolderUploadService::makeFolder(storage_path('app/public/images'), false);
            $destinationPath = str_replace(storage_path('app'), '', $destinationPath);
            $featured_image = $request->file('featured_image')->storeAs($destinationPath, "{$filename}.{$fileExtension}");
            $featured_image = $imageConvertService->fromFile($file)
                ->fromPath(storage_path("app/{$featured_image}"))
                ->convertAllSize(storage_path("app{$destinationPath}"));
            $pageSeo->featured_image = str_replace(storage_path('app/public').'/', '', $featured_image);
        }
        // remove root
        $pageSeo->slug = Str::replace(url('/'), '', $pageSeo->slug);
        $pageSeo->save();
    }

    /**
     * @name Cho phép Seo meta
     */
    public function seoMeta(Request $request, $id)
    {
        $request->validate([
            'question.*' => 'required_with:answer.*',
            'url.*' => 'required_with:question.*',
            'answer.*' => 'required_with:question.*'
        ]);
        $meta_data = Arr::map($request->input('meta_data'), function ($value) {
            return is_null($value) ? '' : $value;
        });
        $faq = [];
        for ($i = 0; $i < 10; $i++) {
            if ($request->filled("question.$i") || $request->filled("answer.$i")) {
                $faq[] = [
                    'question' => $request->input("question.$i"),
                    'url' => $request->input("url.$i"),
                    'answer' => $request->input("answer.$i"),
                ];
            }
        }
        $pageSeo = PageSeo::findOrFail($id);
        $pageSeo->fill($request->except(['meta_data','faq']));
        $pageSeo->related_content = $request->textarea('related_content');
        $pageSeo->meta_data = $meta_data;
        $pageSeo->faq = $faq;
        $pageSeo->save();

        return redirect()->route('admin.seo.page.edit', [$id])->with(['message' => __('Bản ghi đã cập nhật')]);
    }

    /**
     * @name Cho phép Cấu hình Sim
     */
    public function simSetting(Request $request, $id)
    {
        $request->validate([
            'sim_setting.uu_tien_gia_nho' => 'nullable|numeric|gt:sim_setting.uu_tien_gia_lon',
            'sim_setting.uu_tien_gia_lon' => 'nullable|numeric|lt:sim_setting.uu_tien_gia_nho',
        ]);
        $sim_setting = Arr::map($request->input('sim_setting'), function ($value, $key) {
            return is_null($value) ? '' : $value;
        });
        $sim_setting['priority_sims'] = $request->textarea('sim_setting.priority_sims');
        $sim_setting['priority_warehouse'] = $request->textarea('sim_setting.priority_warehouse');
        $pageSeo = PageSeo::findOrFail($id);
        $pageSeo->sim_setting = $sim_setting;
        $pageSeo->save();
        return redirect()->route('admin.seo.page.edit', [$id])->with(['message' => __('Bản ghi đã cập nhật')]);
    }

    /**
     * @name Cho phép xóa
     */
    public function destroy($id)
    {
        PageSeo::destroy($id);
        return redirect()->route('admin.seo.page.index')->with(['message' => __('Bản ghi đã được xóa')]);
    }
}
