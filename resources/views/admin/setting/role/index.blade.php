@extends('layouts.admin')

@section('content')
    <div>
        <div class="d-flex">
            <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                <div>
                    @can('RoleController.create')
                    <a href="{{ route('admin.role.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                        </svg>
                        {{ __('Thêm mới') }}
                    </a>
                    @endif
                </div>
            </div>
            <div class="d-inline-flex gap-1 align-items-center">
                <form action="{{ route('admin.role.index') }}" method="get">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="bi bi-search"></i>
                        </span>
                        <input name="q" value="{{ app('request')->get('q') }}" type="text" class="form-control" placeholder="Từ khóa ..." aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-striped table-hover mt-3">
            <thead class="table-light">
            <tr>
                <th scope="col">{{ __('Nhóm quyền') }}</th>
                <th scope="col" class="text-center">{{ __('Quyền chức năng') }}</th>
                <th scope="col" class="text-center">{{ __('Thành viên') }}</th>
                <th scope="col">{{ __('Cập nhật') }}</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @forelse($roles as $role)
                <tr>
                    <td>
                        <a data-bs-toggle="tooltip" data-bs-title="Sửa nhóm" href="{{ route('admin.role.edit', [$role->id]) }}" class="btn btn-link p-0">{{ $role->name }}</a>
                    </td>
                    <td class="text-center">
                        <button data-bs-toggle="tooltip" data-bs-title="Sửa quyền cho nhóm {{ $role->name }}" type="button" class="btn btn-sm btn-outline-secondary">{{ $role->permissions->count() }}</button>
                    </td>
                    <td class="text-center">
                        <button data-bs-toggle="tooltip" data-bs-title="Thêm thành viên cho nhóm {{ $role->name }}" type="button" class="btn btn-sm btn-outline-secondary">{{ $role->users->count() }}</button>
                    </td>
                    <td>{{ $role->updated_at->format('d/m/Y H:i') }}</td>
                    <th scope="row">
                        <form action="{{ route('admin.role.destroy',[$role->id]) }}" method="post" onsubmit="javascript: return confirm('{{ __('Bạn có chắc chắn muốn xóa') }}')">
                            @csrf
                            @method('delete')
                            @can('RoleController.destroy')
                            <button type="submit" class="btn btn-sm btn-outline-secondary">{{ __('Xóa') }}</button>
                            @endif
                        </form>
                    </th>
                </tr>
            @empty
                <tr>
                    <td colspan="5">{{ __('Không có bản ghi') }}</td>
                </tr>
            @endforelse
            </tbody>
            <caption>
                {{ $roles->withQueryString()->links() }}
            </caption>
        </table>
    </div>
@endsection

