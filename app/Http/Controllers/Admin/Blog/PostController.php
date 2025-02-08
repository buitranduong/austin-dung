<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Blog\Category;
use App\Models\Blog\Post;
use App\Models\Blog\Tag;
use App\Models\User;
use App\Services\EnsureFolderUploadService;
use App\Services\ImageConvertService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * @name Quản lý bài viết
     */
    public function __construct()
    {
        $this->middleware('can:PostController.index');
        $this->middleware('can:PostController.create')->only('create', 'store', 'upload');
        $this->middleware('can:PostController.edit')->only('update', 'upload', 'handleBatchAction');
        $this->middleware('can:PostController.destroy')->only('destroy', 'trash', 'handleTrashBatchAction', 'restore', 'forceDelete');
        $this->middleware('can:PostController.seoMeta')->only('seoMeta');
    }

    /**
     * @name Xem bài viết
     */
    public function index(Request $request)
    {
        $postsQuery = Post::query();
        if ($request->has('q')) {
            $postsQuery->where('title', 'ilike', '%' . $request->get('q') . '%');
        }
        if ($request->has('category')) {
            $postsQuery->whereHas('categories', function ($query) use ($request) {
                $query->where('category_id', $request->get('category'));
            });
        }
        if ($request->has('status')) {
            $status = PostStatus::tryFrom($request->get('status'));
            $postsQuery->isStatus($status);
        }

        if ($request->has('sort') && $request->has('direction')) {
            $postsQuery->orderBy($request->get('sort'), $request->get('direction'));
        } else {
            $postsQuery->orderBy('created_at', 'desc');
        }

        $posts = $postsQuery->paginate()->appends(request()->query());
        $categories = Category::all();
        $status = PostStatus::array();
        return view('admin.blog.post.index', compact('posts', 'categories', 'status'));
    }

    public function handleBatchAction(Request $request)
    {
        $selectedPosts = json_decode($request->input('selected_posts', '[]'));
        try {
            if ($request->input('action') === '3') {
                // Xóa các bài viết đã chọn
                Post::whereIn('id', $selectedPosts)->delete();
                return response()->json(['success' => true, 'message' => 'Đã xóa các bài viết thành công']);
            } else if ($request->input('action') === '2') {
                // Xóa các bài viết đã chọn
                Post::whereIn('id', $selectedPosts)->update(['status' => PostStatus::Published]);
                return response()->json(['success' => true, 'message' => 'Hiển thị các bài viết thành công']);
            } else if ($request->input('action') === '1') {
                // Xóa các bài viết đã chọn
                Post::whereIn('id', $selectedPosts)->update(['status' => PostStatus::Draft]);
                return response()->json(['success' => true, 'message' => 'Dừng hiển thị/ẩn các bài viết thành công']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        }


        return response()->json(['success' => false, 'message' => 'Hành động không hợp lệ', 'selectedpost' => $selectedPosts]);
    }

    /**
     * @name Cho phép tạo mới
     */
    public function create(Request $request)
    {
        if ($request->get('id')) {
            $post = Post::with(['categories'])->findOrFail($request->get('id'));
            $meta_data = [];
            if ($post->meta_data && method_exists($post->meta_data, 'toArray')) {
                $meta_data = $post->meta_data->toArray();
            }
            $post_category_id = $post->category->id;
            $post_tags_id = $post->tags()->get()->pluck('id')->toArray();
            $categories = Category::with('children')->get(['id', 'name']);
            $tags = Tag::all(['id', 'name']);
            $status = PostStatus::array();
            $category = $request->input('category');
            $authors = User::all(['id', 'name']);
            return view('admin.blog.post.replication', compact(
                'post',
                'categories',
                'tags',
                'status',
                'post_category_id',
                'post_tags_id',
                'meta_data',
                'category',
                'authors',
            ));
        }
        $categories = Category::with('children')->get(['id', 'name']);
        $tags = Tag::all(['id', 'name']);
        $status = PostStatus::array();
        $authors = User::active()->get(['id', 'name']);
        return view('admin.blog.post.create', compact('categories', 'status', 'tags', 'authors'));
    }

    public function store(Request $request, ImageConvertService $imageConvertService)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:posts',
            'category_id' => 'required|nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:categories,id',
            'status' => 'required|in:' . implode(',', PostStatus::values()),
        ]);
        $post = new Post;
        $post->fill($request->except(['_token', 'excerpt', 'category_id', 'tags', 'featured_image']));
        $this->_fillImageToSave($post, $request, $imageConvertService);
        $this->_explodeExcerptContent($request->input('content'), $post);
        $post->related_content = $request->textarea('related_content');
        $meta_data = Arr::map($request->input('meta_data'), function ($value) {
            return is_null($value) ? '' : $value;
        });
        if (empty($meta_data['meta']['description'])) {
            $meta_data['meta']['description'] = $post->excerpt;
        }
        $post->meta_data = $meta_data;
        $post->content = html_entity_decode($post->content);
        $post->save();
        if ($request->has('tags')) {
            $post->tags()->sync($request->input('tags'));
        }
        if ($request->has('category_id')) {
            $post->categories()->attach($request->input('category_id'));
        }
        $post->save();
        return redirect()->route('admin.post.edit', [$post->id])->with(['message' => __('Bản ghi đã được thêm')]);
    }

    /**
     * @name Cho phép chỉnh sửa
     */
    public function edit(Request $request, $id)
    {
        // record history for go back
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        if ($route === 'admin.post.index') {
            session(['previous_url' => $url]);
        }
        $post = Post::with(['categories'])->findOrFail($id);
        $meta_data = [];
        if ($post->meta_data && method_exists($post->meta_data, 'toArray')) {
            $meta_data = $post->meta_data->toArray();
        }
        $post_category_id = $post->category->id ?? 0;
        $post_tags_id = $post->tags()->get()->pluck('id')->toArray();
        $categories = Category::with('children')->get(['id', 'name']);
        $tags = Tag::all(['id', 'name']);
        $status = PostStatus::array();
        $category = $request->input('category');
        $authors = User::all(['id', 'name']);
        return view('admin.blog.post.edit', compact(
            'post',
            'categories',
            'tags',
            'status',
            'post_category_id',
            'post_tags_id',
            'meta_data',
            'category',
            'authors'
        ));
    }

    public function update(Request $request, ImageConvertService $imageConvertService, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:posts,slug,' . $id,
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:categories,id',
            'status' => 'required|in:' . implode(',', PostStatus::values()),
        ]);
        $post = Post::findOrFail($id);
        $post->tags()->sync($request->input('tags'));
        $post->categories()->attach($request->input('category_id'));
        $post->fill($request->except(['_method', '_token', 'excerpt', 'category_id', 'tags', 'featured_image']));
        $this->_fillImageToSave($post, $request, $imageConvertService);
        $this->_explodeExcerptContent($request->input('content'), $post);
        $post->content = html_entity_decode($post->content);
        $post->save();
        return redirect()->route('admin.post.edit',[$post->id])->with(['message' => __('Bản ghi đã cập nhật')]);
    }

    /**
     * @name Cho phép Seo meta
     */
    public function seoMeta(Request $request, $id)
    {
        $meta_data = Arr::map($request->input('meta_data'), function ($value) {
            return is_null($value) ? '' : $value;
        });
        $post = Post::findOrFail($id);
        $post->meta_data = $meta_data;
        $post->fill($request->except('meta_data'));
        $post->related_content = $request->textarea('related_content');
        $post->save();
        return redirect()->route('admin.post.edit', [$id])->with(['message' => __('Bản ghi đã cập nhật')]);
    }

    public function trash(Request $request)
    {
        $posts = Post::onlyTrashed()->where(function ($query) use ($request) {
            if ($request->has('q')) {
                $query->where('title', 'ilike', '%' . $request->get('q') . '%');
            }
            if ($request->has('category')) {
                $query->whereHas('categories', function ($query) use ($request) {
                    $query->where('category_id', $request->get('category'));
                });
            }
        })->paginate();
        $categories = Category::all();
        return view('admin.blog.post.trash', compact('posts', 'categories'));
    }

    public function handleTrashBatchAction(Request $request)
    {
        $selectedPosts = json_decode($request->input('selected_posts', '[]'));
        try {
            if ($request->input('action') === '2') {
                // Xóa các bài viết đã chọn
                Post::whereIn('id', $selectedPosts)->forceDelete();
                return response()->json(['success' => true, 'message' => 'Đã xóa vĩnh viễn các bài viết thành công']);
            } else if ($request->input('action') === '1') {
                // Xóa các bài viết đã chọn
                Post::whereIn('id', $selectedPosts)->restore();
                return response()->json(['success' => true, 'message' => 'Đã khôi phục các bài viết thành công']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        }


        return response()->json(['success' => false, 'message' => 'Hành động không hợp lệ', 'selectedpost' => $selectedPosts]);
    }

    public function restore(Request $request, $id)
    {
        Post::withTrashed()->find($id)->restore();
        return redirect()->route('admin.post.trash')->with(['message' => __('Khôi phục thành công bản ghi')]);
    }

    public function forceDelete(Request $request, $id)
    {
        Post::withTrashed()->find($id)->forceDelete();
        return redirect()->route('admin.post.trash')->with(['message' => __('Bản ghi đã được xóa')]);
    }


    /**
     * @name Cho phép xóa
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return redirect()->route('admin.post.index')->with(['message' => __('Bản ghi đã được xóa')]);
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

    private function _fillImageToSave(&$post, $request, ImageConvertService $imageConvertService)
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
            $post->featured_image = str_replace(storage_path('app/public') . '/', '', $featured_image);
        }
    }

    private function _explodeExcerptContent($content, &$post): void
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
                    $post->excerpt = html_entity_decode(strip_tags($html));
                }
                $openedTags = array_reverse($openedTags);
                for ($i = 0; $i < $len_opened; $i++) {
                    if (!in_array($openedTags[$i], $closedTags)) {
                        $html .= '</' . $openedTags[$i] . '>';
                    } else {
                        unset($closedTags[array_search($openedTags[$i], $closedTags)]);
                    }
                }
                $post->excerpt = html_entity_decode(strip_tags($html));
            }
        }
    }
}
