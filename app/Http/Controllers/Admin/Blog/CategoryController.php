<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Services\EnsureFolderUploadService;
use App\Models\Blog\Category;
use App\Services\ImageConvertService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * @name Quản lý chuyên mục
     */
    public function __construct()
    {
        $this->middleware('can:CategoryController.index');
        $this->middleware('can:CategoryController.create')->only('create', 'store', 'upload');
        $this->middleware('can:CategoryController.edit')->only('update', 'publish', 'upload');
        $this->middleware('can:CategoryController.destroy')->only('destroy');
        $this->middleware('can:CategoryController.seoMeta')->only('seoMeta');
    }

    /**
     * @name Xem danh sách
     */
    public function index(Request $request)
    {
        $categories = Category::where(function ($query) use ($request){
            if($request->get('q')){
                $query->where('name', 'ilike', "%{$request->get('q')}%");
            }
        })->paginate()
        ->withQueryString();
        return view('admin.blog.category.index', compact('categories'));
    }

    /**
     * @name Cho phép tạo mới
     */
    public function create()
    {
        $categories = Category::with('children')->root()->get();
        return view('admin.blog.category.create', compact('categories'));
    }

    public function store(Request $request, ImageConvertService $imageConvertService)
    {
        $request->validate([
            'name' => 'required|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        $category = new Category();
        $category->fill($request->except('featured_image'));
        $this->_fillImageToSave($category, $request, $imageConvertService);
        $meta_data = Arr::map($request->input('meta_data'), function ($value) {
            return is_null($value) ? '' : $value;
        });
        $category->meta_data = $meta_data;
        $category->save();
        if ($request->has('redirect')) {
            return redirect($request->input('redirect'));
        }
        return redirect()->route('admin.category.edit', [$category->id])->with(['message' => __('Bản ghi đã được tạo')]);
    }

    /**
     * @name Cho phép chỉnh sửa
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $meta_data = [];
        if ($category->meta_data && method_exists($category->meta_data, 'toArray')) {
            $meta_data = $category->meta_data->toArray();
        }
        $head_script = $category->head_script;
        $related_content = $category->related_content;
        $categories = Category::with('children')
            ->where('id', '!=', $id)
            ->root()
            ->get(['id', 'name']);
        return view('admin.blog.category.edit', compact('category', 'categories', 'meta_data', 'head_script', 'related_content'));
    }

    public function update(Request $request, ImageConvertService $imageConvertService, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug,' . $id,
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        $category = Category::findOrFail($id);
        $category->fill($request->except('featured_image'));
        $this->_fillImageToSave($category, $request, $imageConvertService);
        $category->save();
        return redirect()->route('admin.category.index')->with(['message' => __('Bản ghi đã cập nhật')]);
    }

    public function upload(Request $request, ImageConvertService $imageConvertService)
    {
        $request->validate([
            'file'=>'required|image|max:2048'
        ]);
        if($request->file('file')->isValid())
        {
            try{
                $file = $request->file('file');
                $filePath = $file->store('public/tmp');
                if ($filePath) {
                    $destinationPath = EnsureFolderUploadService::makeFolder(storage_path('app/public/uploads'));
                    $location = $imageConvertService->fromFile($file)
                        ->fromPath(storage_path("app/{$filePath}"))
                        ->convertFitSize($destinationPath);
                    $location = str_replace(storage_path('app/public'), url('storage'), $location);
                    return response()->json(['location'=>$location,'link'=>url('storage')]);
                }
            }catch (\Exception $exception){
                return response()->json(['message' => $exception->getMessage()], 500);
            }
        }

        return response()->json(['message'=>'File is invalid'], 500);
    }

    /**
     * @name Cho phép Seo meta
     */
    public function seoMeta(Request $request, $id)
    {
        $meta_data = Arr::map($request->input('meta_data'), function ($value) {
            return is_null($value) ? '' : $value;
        });
        $category = Category::findOrFail($id);
        $category->meta_data = $meta_data;
        $category->fill($request->except('meta_data'));
        $category->save();

        return redirect()->route('admin.category.edit', [$id])->with(['message' => __('Bản ghi đã cập nhật')]);
    }

    public function publish(Request $request, $id)
    {
        $request->validate([
            'published' => 'required|boolean',
        ]);
        $category = Category::findOrFail($id);
        $category->published = $request->input('published');
        $category->save();
        return redirect()->route('admin.category.index')->with(['message' => __('Bản ghi đã cập nhật')]);
    }

    public function featured(Request $request, $id)
    {
        $request->validate([
            'featured' => 'required|boolean',
        ]);
        $category = Category::findOrFail($id);
        $category->featured = $request->input('featured');
        $category->save();
        return redirect()->route('admin.category.index')->with(['message' => __('Bản ghi đã cập nhật')]);
    }

    public function trash(Request $request)
    {
        $categories = Category::onlyTrashed()->where(function ($query) use ($request){
            if($request->get('q')){
                $query->where('name', 'ilike', "%{$request->get('q')}%");
            }
        })->paginate();
        return view('admin.blog.category.trash', compact('categories'));
    }

    public function restore(Request $request,$id)
    {
        Category::withTrashed()->find($id)->restore();
        return redirect()->route('admin.category.trash')->with(['message' => __('Khôi phục thành công bản ghi')]);
    }

    public function forceDelete(Request $request,$id)
    {
        Category::withTrashed()->find($id)->forceDelete();
        return redirect()->route('admin.category.trash')->with(['message' => __('Bản ghi đã được xóa')]);
    }

    /**
     * @name Cho phép xóa
     */
    public function destroy($id)
{
    $category = Category::findOrFail($id);

    // Kiểm tra xem có bài viết nào thuộc chuyên mục này không
    if ($category->posts()->exists()) {
        return redirect()->route('admin.category.index')->with(['message' => __('Không thể xóa chuyên mục có bài viết liên quan')]);
    }

    // Cập nhật parent_id của các chuyên mục con về null
    $category->children()->update(['parent_id' => null]);

    // Xóa chuyên mục
    $category->delete();

    return redirect()->route('admin.category.index')->with(['message' => __('Bản ghi đã được xóa')]);
}


    private function _fillImageToSave(&$category, $request, ImageConvertService $imageConvertService): void
    {
        if ($request->hasFile('featured_image') && $request->file('featured_image')->isValid()) {
            $file = $request->file('featured_image');
            $filename = $file->getClientOriginalName();
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
            $filename = Str::of($filename)->basename(".{$fileExtension}")->slug();
            $destinationPath = EnsureFolderUploadService::makeFolder(storage_path('app/public/uploads'));
            $destinationPath = str_replace(storage_path('app'), '', $destinationPath);
            $featured_image = $request->file('featured_image')->storeAs($destinationPath, "{$filename}.{$fileExtension}");
            $featured_image = $imageConvertService->fromFile($file)
                ->fromPath(storage_path("app/{$featured_image}"))
                ->convertAllSize(storage_path("app{$destinationPath}"));
            $category->featured_image = str_replace(storage_path('app/public').'/', '', $featured_image);
        }
    }
}
