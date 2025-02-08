@extends('layouts.admin')

@section('content')
    <div>
        <div class="d-flex">
            <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                <div>
                    @can('UserController.create')
                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                        </svg>
                        {{ __('Thêm mới') }}
                    </a>
                    @endif
                </div>
            </div>
            <div class="d-inline-flex gap-1 align-items-center">
                <form action="" method="get">
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
                <th scope="col">{{ __('Tên') }}</th>
                <th scope="col">{{ __('Email') }}</th>
                <th scope="col" class="text-center">{{ __('Nhóm quyền') }}</th>
                <th scope="col" class="text-center">{{ __('Trạng thái') }}</th>
                <th scope="col">{{ __('Đăng nhập') }}</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>
                        <a data-bs-toggle="tooltip" data-bs-title="Sửa tên" href="{{ route('admin.user.edit', [$user->id]) }}" class="btn btn-link p-0">{{ $user->name }}</a>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td class="text-center">
                        @forelse($user->roles as $role)
                            <a href="" data-bs-toggle="tooltip" data-bs-title="Xem nhóm {{ $role->name }}" type="button" class="btn btn-sm btn-outline-secondary" @cannot('UserController.edit') style="pointer-events: none;" @endif>{{ $role->name }}</a>
                            @empty
                            <a data-bs-toggle="tooltip" data-bs-title="{{ __('Phân loại') }}" href="{{ route('admin.user.edit', [$user->id]) }}" class="btn btn-secondary btn-sm" @cannot('UserController.edit') style="pointer-events: none;" @endif><i class="bi bi-plus-circle-fill"></i></a>
                        @endforelse
                    </td>
                    <td class="text-center">
                        <form action="{{ route('admin.user.active', [$user->id]) }}" method="post">
                            @csrf
                            @method('patch')
                            @if($user->is_active)
                                <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-title="Chuyển dừng hoạt động" @cannot('UserController.edit') disabled @endif>
                                    <i class="bi bi-check-circle-fill"></i>
                                </button>
                                <input type="hidden" name="is_active" value="0">
                            @else
                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-title="Chuyển kích hoạt" @cannot('UserController.edit') disabled @endif>
                                    <i class="bi bi-x-circle-fill"></i>
                                </button>
                                <input type="hidden" name="is_active" value="1">
                            @endif
                        </form>
                    </td>
                    <td>{{ !empty($user->last_login_at) ?  $user->last_login_at->locale('vi')->diffForHumans() : '' }}</td>
                    <td>
                        <form action="{{ route('admin.user.destroy',[$user->id]) }}" method="post" onsubmit="javascript: return confirm('{{ __('Bạn có chắc chắn muốn xóa') }}')">
                            @csrf
                            @method('delete')
                            @can('UserController.destroy')
                            <button type="submit" class="btn btn-sm btn-outline-secondary">{{ __('Xóa') }}</button>
                            @endif
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="6">{{ __('Không có bản ghi') }}</td>
                </tr>
            @endforelse
            </tbody>
            <caption>
                {{ $users->withQueryString()->links() }}
            </caption>
        </table>
    </div>
@endsection

