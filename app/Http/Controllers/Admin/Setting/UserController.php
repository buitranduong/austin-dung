<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EnsureFolderUploadService;
use App\Services\ImageConvertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    /**
     * @name Quản lý người dùng
     */
    public function __construct()
    {
        $this->middleware('can:UserController.index');
        $this->middleware('can:UserController.create')->only('create', 'store');
        $this->middleware('can:UserController.edit')->only('update', 'active');
        $this->middleware('can:UserController.destroy')->only('destroy');
    }

    /**
     * @name Xem danh sách
     */
    public function index(Request $request)
    {
        $users = User::with('roles')
            ->where(function ($query) use ($request){
            if($request->get('q')) {
                $query->where('name', 'ilike', '%'. $request->get('q') .'%');
            }
        })->orderBy('name')->paginate();
        return view('admin.setting.user.index', compact('users'));
    }

    /**
     * @name Cho phép tạo mới
     */
    public function create(Request $request)
    {
        if($request->user()->hasRole('Super-Admin')){
            $roles = Role::all();
        }else{
            $roles = Role::where('name','!=','Super-Admin')->get();
        }
        return view('admin.setting.user.create', compact('roles'));
    }

    public function store(Request $request, ImageConvertService $imageConvertService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $user = new User();
        $user->fill($request->except(['password','avatar']));
        $user->password = Hash::make($request->input('password'));
        $this->_fillImageToSave($user, $request, $imageConvertService);
        $user->save();
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if($request->user()->hasRole('Super-Admin'))
        {
            if ($request->input('role')) {
                $user->assignRole($request->input('role'));
            }
        }elseif (!$request->input('role') == 'Super-Admin' and !$request->user()->hasRole('Super-Admin'))
        {
            if ($request->input('role')) {
                $user->assignRole($request->input('role'));
            }
        }else{
            return redirect()->back()->withErrors(['message'=>__('Bạn không có quyền thực hiện chức năng này')]);
        }
        // ghi log
        activity('User')
            ->causedBy($request->user())
            ->performedOn($user)
            ->withProperties($request->except('_token'))
            ->log('create user');
        return redirect()->route('admin.user.index')->with(['message'=> __('Bản ghi đã được tạo')]);
    }

    /**
     * @name Cập nhật
     */
    public function edit(Request $request, $id)
    {
        $user = User::with('roles')->findOrFail($id);
        if($user->hasRole('Super-Admin') and !$request->user()->hasRole('Super-Admin'))
        {
            return redirect()->back()->withErrors(['message'=>__('Bạn không có quyền thực hiện chức năng này')]);
        }
        $assigned = $user->roles->first();
        if($request->user()->hasRole('Super-Admin')){
            $roles = Role::all();
        }else{
            $roles = Role::where('name','!=','Super-Admin')->get();
        }
        return view('admin.setting.user.edit', compact('user','assigned','roles'));
    }

    public function update(Request $request, $id, ImageConvertService $imageConvertService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:6',
            'slug' => 'required|string|max:100|unique:users,slug,'.$id,
            'facebook' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'x' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'content' => 'nullable|string',
        ]);

        $user = User::findOrFail($id);
        $user->fill($request->except(['password', 'avatar']));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        if($request->user()->hasRole('Super-Admin'))
        {
            if ($request->input('role')) {
                $user->syncRoles([$request->input('role')]);
            }
        }elseif (!$user->hasRole('Super-Admin') and !$request->user()->hasRole('Super-Admin'))
        {
            if ($request->input('role')) {
                $user->syncRoles([$request->input('role')]);
            }
        }else{
            return redirect()->back()->withErrors(['message'=>__('Bạn không có quyền thực hiện chức năng này')]);
        }
        $this->_fillImageToSave($user, $request, $imageConvertService);
        $user->content = html_entity_decode($request->input('content'));
        $user->save();
        // ghi log
        activity('User')
            ->causedBy($request->user())
            ->performedOn($user)
            ->withProperties($request->except('_token'))
            ->log('edit user');
        return redirect()->route('admin.user.index')->with(['message' => __('Bản ghi đã cập nhật')]);
    }

    public function active(Request $request, $id)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);
        $user = User::findOrFail($id);
        if(
            ($user->hasRole('Super-Admin') and !$request->user()->hasRole('Super-Admin'))
            or ($id == $request->user()->id)
        ){
            return redirect()->back()->withErrors(['message'=>__('Bạn không có quyền thực hiện chức năng này')]);
        }
        $user->is_active = $request->input('is_active');
        $user->save();
        return redirect()->route('admin.user.index')->with(['message'=> __('Bản ghi đã cập nhật')]);
    }

    /**
     * @name Cho phép xóa
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if(
            ($user->hasRole('Super-Admin') and !$request->user()->hasRole('Super-Admin'))
            or ($id == $request->user()->id)
        ){
            return redirect()->back()->withErrors(['message'=>__('Bạn không có quyền thực hiện chức năng này')]);
        }
        $user->roles()->detach();
        $user->delete();
        // ghi log
        activity('User')
            ->causedBy($request->user())
            ->performedOn($user)
            ->withProperties(['id'=>$id])
            ->log('delete user');
        return redirect()->route('admin.user.index')->with(['message'=> __('Bản ghi đã được xóa')]);
    }

    private function _fillImageToSave(&$user, $request, ImageConvertService $imageConvertService)
    {
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $file = $request->file('avatar');
            $filename = $file->getClientOriginalName();
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
            $filename = Str::of($filename)->basename(".{$fileExtension}")->slug();
            $destinationPath = EnsureFolderUploadService::makeFolder(storage_path('app/public/uploads/avatar'), false);
            $destinationPath = str_replace(storage_path('app'), '', $destinationPath);
            $avatar_image = $request->file('avatar')->storeAs($destinationPath, "{$filename}.{$fileExtension}");
            $avatar_image = $imageConvertService->fromFile($file)
                ->fromPath(storage_path("app/{$avatar_image}"))
                ->convertThumbnailSize(storage_path("app{$destinationPath}"), true);
            $user->avatar = str_replace(storage_path('app/public').'/', '', $avatar_image);
        }
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
}
