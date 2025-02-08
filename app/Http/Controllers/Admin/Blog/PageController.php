<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Blog\Page;
use App\Services\EnsureFolderUploadService;
use App\Services\ImageConvertService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * @name Quản lý trang
     */
    public function __construct()
    {
        $this->middleware('can:PageController.index');
        $this->middleware('can:PageController.create')->only('create', 'store', 'upload');
        $this->middleware('can:PageController.edit')->only('update', 'upload', 'handleBatchAction');;
        $this->middleware('can:PageController.destroy')->only('destroy', 'trash', 'handleTrashBatchAction', 'restore', 'forceDelete');
        $this->middleware('can:PageController.seoMeta')->only('seoMeta');
    }

    /**
     * @name Xem danh sách
     */
    public function index(Request $request)
    {
        $pagesQuery = Page::query();
        if ($request->has('q')) {
            $pagesQuery->where('title', 'ilike', '%' . $request->get('q') . '%');
        }
        if ($request->has('sort') && $request->has('direction')) {
            $pagesQuery->orderBy($request->get('sort'), $request->get('direction'));
        } else {
            $pagesQuery->orderBy('created_at', 'desc');
        }
        $pages = $pagesQuery->paginate()->appends(request()->query());
        return view('admin.blog.page.index',compact('pages'));
    }

    public function handleBatchAction(Request $request)
    {
        $selectedPages = json_decode($request->input('selected_pages', '[]'));
        try {
            if ($request->input('action') === '3') {
                // Xóa các trang đã chọn
                Page::whereIn('id', $selectedPages)->delete();
                return response()->json(['success' => true, 'message' => 'Đã xóa các trang thành công']);
            } else if ($request->input('action') === '2') {
                // Xóa các trang đã chọn
                Page::whereIn('id', $selectedPages)->update(['status' => PostStatus::Published]);
                return response()->json(['success' => true, 'message' => 'Hiển thị các trang thành công']);
            } else if ($request->input('action') === '1') {
                // Xóa các trang đã chọn
                Page::whereIn('id', $selectedPages)->update(['status' => PostStatus::Draft]);
                return response()->json(['success' => true, 'message' => 'Dừng hiển thị/ẩn các trang thành công']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        }


        return response()->json(['success' => false, 'message' => 'Hành động không hợp lệ', 'selectedpages' => $selectedPages]);
    }

    /**
     * @name Cho phép tạo mới
     */
    public function create()
    {
        $status = PostStatus::array();
        return view('admin.blog.page.create',compact('status'));
    }

    public function store(Request $request, ImageConvertService $imageConvertService)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:posts',
            'status' => 'required|in:' . implode(',', PostStatus::values()),
        ]);
        $page = new Page();
        $page->fill($request->except(['_token', 'excerpt', 'category_id', 'tags', 'featured_image']));
        $page->related_content = $request->textarea('related_content');
        $this->_fillImageToSave($page, $request, $imageConvertService);
        $this->_explodeExcerptContent($request->input('content'), $page);
        $meta_data = Arr::map($request->input('meta_data'), function ($value) {
            return is_null($value) ? '' : $value;
        });

        if(empty($meta_data['meta']['description'])){
            $meta_data['meta']['description'] = $page->excerpt;
        }
        $page->meta_data = $meta_data;
        $page->save();

        return redirect()->route('admin.page.edit', [$page->id])->with(['message' => __('Bản ghi đã được thêm')]);
    }

    /**
     * @name Cho phép chỉnh sửa
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $meta_data = [];
        if ($page->meta_data && method_exists($page->meta_data, 'toArray')) {
            $meta_data = $page->meta_data->toArray();
        }
        $status = PostStatus::array();
        return view('admin.blog.page.edit', compact(
            'page',
            'status',
            'meta_data',
        ));
    }

    public function update(Request $request,ImageConvertService $imageConvertService, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:posts,slug,' . $id,
            'status' => 'required|in:' . implode(',', PostStatus::values()),
        ]);
        $page = Page::findOrFail($id);
        $page->fill($request->except(['_method', '_token', 'excerpt', 'featured_image']));
        $this->_fillImageToSave($page, $request, $imageConvertService);
        $this->_explodeExcerptContent($request->input('content'), $page);
        $page->save();
        return redirect()->route('admin.page.index')->with(['message' => __('Bản ghi đã cập nhật')]);
    }

    public function trash(Request $request)
    {
        $pages = Page::onlyTrashed()->where(function ($query) use ($request) {
            if ($request->get('q')) {
                $query->where('title', 'ilike', '%' . $request->get('q') . '%');
            }
        })->paginate();
        return view('admin.blog.page.trash', compact('pages'));
    }
    public function handleTrashBatchAction(Request $request)
    {
        $selectedPages = json_decode($request->input('selected_pages', '[]'));
        try {
            if ($request->input('action') === '2') {
                // Xóa các trang đã chọn
                Page::whereIn('id', $selectedPages)->forceDelete();
                return response()->json(['success' => true, 'message' => 'Đã xóa vĩnh viễn các trang thành công']);
            } else if ($request->input('action') === '1') {
                // Xóa các trang đã chọn
                Page::whereIn('id', $selectedPages)->restore();
                return response()->json(['success' => true, 'message' => 'Đã khôi phục các trang thành công']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        }


        return response()->json(['success' => false, 'message' => 'Hành động không hợp lệ', 'selectedpage' => $selectedPages]);
    }
    public function restore(Request $request, $id)
    {
        Page::withTrashed()->find($id)->restore();
        return redirect()->route('admin.page.trash')->with(['message' => __('Khôi phục thành công bản ghi')]);
    }

    public function forceDelete(Request $request, $id)
    {
        Page::withTrashed()->find($id)->forceDelete();
        return redirect()->route('admin.page.trash')->with(['message' => __('Bản ghi đã được xóa')]);
    }

    /**
     * @name Cho phép xóa
     */
    public function destroy($id)
    {
        Page::destroy($id);
        return redirect()->route('admin.page.index')->with(['message' => __('Bản ghi đã được xóa')]);
    }

    /**
     * @name Cho phép Seo meta
     */
    public function seoMeta(Request $request, $id)
    {
        $meta_data = Arr::map($request->input('meta_data'), function ($value) {
            return is_null($value) ? '' : $value;
        });
        $page = Page::findOrFail($id);
        $page->meta_data = $meta_data;
        $page->fill($request->except('meta_data'));
        $page->related_content = $request->textarea('related_content');
        $page->save();
        return redirect()->route('admin.page.edit', [$id])->with(['message' => __('Bản ghi đã cập nhật')]);
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

    private function _fillImageToSave(&$page, $request, ImageConvertService $imageConvertService)
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
            $page->featured_image = str_replace(storage_path('app/public').'/', '', $featured_image);
        }
    }
    private function _explodeExcerptContent($content, &$page): void
    {
        if (!empty($content)) {
            $content = explode("<!-- pagebreak -->", $content);
            if (count($content) > 1) {
                $html = trim($content[0]);
                preg_match_all('#<([a-zA-Z0-9]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
                $openedTags = $result[1];
                preg_match_all('#</([a-zA-Z0-9]+)>#iU', $html, $result);

                $closedTags = $result[1];
                $len_opened = count($openedTags);

                if (count($closedTags) == $len_opened) {
                    $page->excerpt = html_entity_decode(strip_tags($html));
                }
                $openedTags = array_reverse($openedTags);
                for ($i = 0; $i < $len_opened; $i++) {
                    if (!in_array($openedTags[$i], $closedTags)) {
                        $html .= '</' . $openedTags[$i] . '>';
                    } else {
                        unset($closedTags[array_search($openedTags[$i], $closedTags)]);
                    }
                }
                $page->excerpt = html_entity_decode(strip_tags($html));
            }
        }
    }
}
