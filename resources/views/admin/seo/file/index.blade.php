@extends('layouts.admin')

@section('content')
    <div>
        <div class="d-flex">
            <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                <div>
                    @can('FileController.create')
                    <a href="{{ route('admin.seo.file.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                        </svg>
                        {{ __('Thêm mới') }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover mt-3">
            <thead class="table-light">
            <tr>
                <th scope="col" class="col">{{ __('Tên file') }}</th>
                <th scope="col" class="col-1"></th>
            </tr>
            </thead>
            <tbody>
            @forelse($files as $file)
                <tr>
                    <td class="text-start">{{ $file->name }}</td>
                    <td>
                        <div class="d-flex d-flex-inline gap-2">
                            <a href="{{ route('admin.seo.file.edit',[$file->id]) }}" class="btn btn-sm btn-outline-warning">{{ __('Sửa') }}</a>
                            @can('FileController.destroy')
                            <form action="{{ route('admin.seo.file.destroy',[$file->id]) }}" method="post" onsubmit="javascript: return confirm('{{ __('Thao tác không thể phục hồi, bạn chắc chắn muốn xóa?') }}');">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-secondary">{{ __('Xóa') }}</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="2">{{ __('Không có bản ghi') }}</td>
                </tr>
            @endforelse
            </tbody>
            <caption>
                {{ $files->links() }}
            </caption>
        </table>
    </div>
@endsection

