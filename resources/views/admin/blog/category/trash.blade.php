@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex">
            <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                <div>
                    <a href="{{ route('admin.category.index') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                        </svg>
                        {{ __('Quay lại') }}
                    </a>
                </div>
            </div>
            <div class="d-inline-flex gap-1 align-items-center">
                <form action="{{ route('admin.category.trash') }}" method="get">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="bi bi-search"></i>
                        </span>
                        <input name="q" value="{{ app('request')->get('q') }}" type="text" class="form-control"
                            placeholder="Từ khóa ..." aria-label="Username" aria-describedby="basic-addon1">
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
                    <th scope="col" class="text-center">{{ __('Trạng thái') }}</th>
                    <th scope="col">{{ __('Ngày tạo') }}</th>
                    <th scope="col">{{ __('Cập nhật') }}</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <x-admin.category.trash-category :category="$category" />
                @empty
                    <tr>
                        <td class="text-center" colspan="9">{{ __('Không có bản ghi') }}</td>
                    </tr>
                @endforelse
            </tbody>
            <caption>
                {{ $categories->links() }}
            </caption>
        </table>
    </div>
@endsection
