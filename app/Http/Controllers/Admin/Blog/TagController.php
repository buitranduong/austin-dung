<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Services\CacheModelService;
use App\Services\EnsureFolderUploadService;
use App\Models\Blog\Tag;
use App\Services\ImageConvertService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * @name Quản lý thẻ
     */
    public function __construct()
    {
        $this->middleware('can:TagController.index');
        $this->middleware('can:TagController.create')->only('create', 'store', 'upload');
        $this->middleware('can:TagController.edit')->only('update', 'upload');
        $this->middleware('can:TagController.destroy')->only('destroy');
        $this->middleware('can:TagController.seoMeta')->only('seoMeta');
    }

    /**
     * @name Xem danh sách
     */
    public function index(Request $request)
    {
        $tags = Tag::where(function ($query) use ($request){
            if($request->get('q')){
                $query->where('name', 'ilike', "%{$request->get('q')}%");
            }
        })->paginate()
        ->withQueryString();
        return view('admin.blog.tag.index', compact('tags'));
    }

    /**
     * @name Cho phép tạo mới
     */
    public function create()
    {
        return view('admin.blog.tag.create');
    }

    public function store(Request $request, ImageConvertService $imageConvertService)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);
        $tag = new Tag();
        $tag->fill($request->except(['featured_image']));
        $this->_fillImageToSave($tag, $request, $imageConvertService);
        $meta_data = Arr::map($request->input('meta_data'), function ($value) {
            return is_null($value) ? '' : $value;
        });
        $tag->meta_data = $meta_data;
        $tag->save();
        CacheModelService::setBlogTags();
        if($request->has('redirect')){
            return redirect($request->input('redirect'));
        }
        return redirect()->route('admin.tag.edit',[$tag->id])->with(['message' => __('Bản ghi đã được tạo')]);
    }

    /**
     * @name Cho phép chỉnh sửa
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $meta_data = [];
        if($tag->meta_data && method_exists($tag->meta_data, 'toArray')){
            $meta_data = $tag->meta_data->toArray();
        }
        return view('admin.blog.tag.edit', compact('tag','meta_data'));
    }

    public function update(Request $request, ImageConvertService $imageConvertService, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug,'.$id,
        ]);
        $tag = Tag::findOrFail($id);
        $tag->fill($request->except(['featured_image']));
        $this->_fillImageToSave($tag, $request, $imageConvertService);
        $tag->save();
        CacheModelService::setBlogTags();
        return redirect()->route('admin.tag.index')->with(['message'=> __('Bản ghi đã cập nhật')]);
    }

    public function featured(Request $request, $id)
    {
        $request->validate([
            'featured' => 'required|boolean',
        ]);
        $tag = Tag::findOrFail($id);
        $tag->featured = $request->input('featured');
        $tag->save();
        return redirect()->route('admin.tag.index')->with(['message' => __('Bản ghi đã cập nhật')]);
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
     * @name Seo meta
     */
    public function seoMeta(Request $request, $id)
    {
        $meta_data = Arr::map($request->input('meta_data'), function ($value) {
            return is_null($value) ? '' : $value;
        });
        $tag = Tag::findOrFail($id);
        $tag->meta_data = $meta_data;
        $tag->fill($request->except('meta_data'));
        $tag->save();

        return redirect()->route('admin.tag.edit', [$id])->with(['message' => __('Bản ghi đã cập nhật')]);
    }

    public function trash(Request $request)
    {
        $tags = Tag::onlyTrashed()->where(function ($query) use ($request){
            if($request->get('q')){
                $query->where('name', 'ilike', "%{$request->get('q')}%");
            }
        })->paginate();
        return view('admin.blog.tag.trash', compact('tags'));
    }

    public function restore(Request $request,$id)
    {
        Tag::withTrashed()->find($id)->restore();
        return redirect()->route('admin.tag.trash')->with(['message' => __('Khôi phục thành công bản ghi')]);
    }

    public function forceDelete(Request $request,$id)
    {
        Tag::withTrashed()->find($id)->forceDelete();
        return redirect()->route('admin.tag.trash')->with(['message' => __('Bản ghi đã được xóa')]);
    }

    /**
     * @name Cho phép xóa
     */
    public function destroy($id)
    {
        Tag::findOrFail($id)->delete();
        return redirect()->route('admin.tag.index')->with(['message'=> __('Bản ghi đã được xóa')]);
    }

    private function _fillImageToSave(&$tag, $request, ImageConvertService $imageConvertService): void
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
            $tag->featured_image = str_replace(storage_path('app/public').'/', '', $featured_image);
        }
    }
}
