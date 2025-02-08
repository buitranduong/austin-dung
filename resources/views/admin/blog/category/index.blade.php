@extends('layouts.admin')

@section('content')
    <div>
        <div class="d-flex">
            <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                <div>
                    @can('CategoryController.create')
                    <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                        </svg>
                        {{ __('Thêm mới') }}
                    </a>
                    @endif
                </div>
                <div>
                    <a href="{{ route('admin.category.trash') }}" class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                          </svg>
                        {{ __('Thùng rác') }}
                    </a>
                </div>
            </div>
            <div class="d-inline-flex gap-1 align-items-center">
                <form action="{{ route('admin.category.index') }}" method="get">
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
                <th scope="col">{{ __('Tên danh mục') }}</th>
                <th scope="col">{{ __('Ảnh') }}</th>
                <th scope="col">{{ __('Slug') }}</th>
                <th scope="col">{{ __('Mô tả') }}</th>
                <th scope="col" class="text-center">{{ __('Nổi bật') }}</th>
                <th scope="col" class="text-center">{{ __('Trạng thái') }}</th>
                <th scope="col">{{ __('Ngày tạo') }}</th>
                <th scope="col">{{ __('Cập nhật') }}</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @forelse($categories as $category)
                <x-admin.category.table :category="$category"/>
            @empty
                <tr>
                  <td class="text-center" colspan="8">{{ __('Không có bản ghi') }}</td>
                </tr>
            @endforelse
            </tbody>
            <caption>
                {{ $categories->withQueryString()->links() }}
            </caption>
        </table>
    </div>
@endsection

