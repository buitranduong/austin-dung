<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Services\ReflectionRegisterRoleService as RegisterRoleService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * @name Quản lý nhóm quyền
     */
    public function __construct()
    {
        $this->middleware('can:RoleController.index');
        $this->middleware('can:RoleController.create')->only('create', 'store');
        $this->middleware('can:RoleController.edit')->only('update');
        $this->middleware('can:RoleController.destroy')->only('destroy');
    }

    /**
     * @name Xem danh sách
     */
    public function index(Request $request): View
    {
        $roles = Role::with(['permissions','users'])
            ->where(function ($query) use ($request) {
            if($request->get('q')){
                $query->where('name', 'ilike', '%'. $request->get('q') .'%');
            }
        })->paginate();
        return view('admin.setting.role.index', compact('roles'));
    }

    /**
     * @name Cho phép tạo mới
     */
    public function create(RegisterRoleService  $service): View
    {
        $permissions = $service->reflectionRegisterRole();
        $assigned = old('permissions', []);
        return view('admin.setting.role.create', compact('permissions','assigned'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:roles',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        $permissions = $request->input('permissions');
        if($permissions){
            foreach($permissions as $name){
                $permission = Permission::findOrCreate($name);
                $permission->assignRole($role);
            }
        }
        // ghi log
        activity('RolePermission')
            ->causedBy($request->user())
            ->withProperties($request->except('_token'))
            ->log('create role permission');
        return redirect()->back()->with(['message'=> __('Bản ghi đã được tạo')]);
    }

    /**
     * @name Cho phép chỉnh sửa
     */
    public function edit(RegisterRoleService  $service, $id): View
    {
        $role = Role::findOrFail($id);
        $permissions = $service->reflectionRegisterRole();
        $assigned = $role->permissions->pluck('name')->all();
        return view('admin.setting.role.edit', compact('role','permissions', 'assigned'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|unique:roles,name,'.$id,
        ]);
        $role = Role::findOrFail($id);
        $role->update(['name'=>$request->input('name')]);
        $permissions = $request->input('permissions');
        $role->permissions()->detach();
        if ($permissions) {
            foreach ($permissions as $name) {
                $permission = Permission::findOrCreate($name);
                $role->givePermissionTo($permission);
            }
        }
        // ghi log
        activity('RolePermission')
            ->causedBy($request->user())
            ->withProperties($request->except('_token'))
            ->log('edit role permission');
        return redirect()->route('admin.role.index')->with(['message'=> __('Bản ghi đã được cập nhật')]);
    }

    /**
     * @name Cho phép xóa
     */
    public function destroy(Request $request, $id)
    {
        Role::findById($id)->delete();
        // ghi log
        activity('RolePermission')
            ->causedBy($request->user())
            ->withProperties(['id'=>$id])
            ->log('delete role permission');
        return redirect()->back()->with(['message'=> __('Bản ghi đã được xóa')]);
    }
}
