@extends('layouts.admin')

@section('content')
    <div>
        <div class="d-flex">
            <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                <div>
                    @can('SeoController.create')
                    <a href="{{ route('admin.seo.page.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                        </svg>
                        {{ __('Thêm mới') }}
                    </a>
                    @endif
                </div>
            </div>
            <div class="d-inline-flex gap-1 align-items-center">
                <form action="{{ route('admin.seo.page.index') }}" method="get">
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
                    <th scope="col">{{ __('Tiêu đề') }}</th>
                    <th scope="col">{{ __('Slug') }}</th>
                    <th scope="col" class="text-center">{{ __('Trạng thái') }}</th>
                    <th scope="col">{{ __('Người tạo') }}</th>
                    <th scope="col">{{ __('Ngày hiển thị') }}</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($seoPages as $page)
                    <tr>
                        <td><a data-bs-toggle="tooltip" data-bs-title="Sửa {{ $page->title }}"
                                href="{{ route('admin.seo.page.edit', [$page->id]) }}"
                                class="btn btn-link p-0 text-start">{{ $page->title }}</a></td>
                        <td>{{ $page->slug }}</td>
                        <td class="text-center">
                            <form action="{{ route('admin.seo.page.active', [$page->id]) }}" method="post">
                                @csrf
                                @method('patch')
                                @if ($page->status == \App\Enums\PageStatus::Published)
                                    <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="Chuyển dừng hoạt động" @cannot('SeoController.edit') disabled @endif>
                                        <i class="bi bi-check-circle-fill"></i>
                                    </button>
                                    <input type="hidden" name="status" value="{{ \App\Enums\PageStatus::Hidden }}">
                                @else
                                    <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="Chuyển kích hoạt" @cannot('SeoController.edit') disabled @endif>
                                        <i class="bi bi-x-circle-fill"></i>
                                    </button>
                                    <input type="hidden" name="status" value="{{ \App\Enums\PageStatus::Published }}">
                                @endif
                            </form>
                        </td>
                        <td>
                            {{ $page->createdByUser->name }}
                        </td>
                        <td>{{ !empty($page->published_at) ? $page->published_at->locale('vi')->diffForHumans() : '' }}
                        </td>
                        <td>
                            @can('SeoController.destroy')
                            <form action="{{ route('admin.seo.page.destroy', [$page->id]) }}" method="post" onsubmit="javascript: return confirm('{{ __('Thao tác này không thể khôi phục, bạn chắc chắn muốn xóa?') }}')">
                                @method('delete')
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary" type="submit">{{ __('Xóa') }}</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">{{ __('Không có bản ghi') }}</td>
                    </tr>
                @endforelse
            </tbody>
            <caption>
                {{ $seoPages->withQueryString()->links() }}
            </caption>
        </table>
    </div>
@endsection
