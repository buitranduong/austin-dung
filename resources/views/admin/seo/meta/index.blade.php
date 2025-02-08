@extends('layouts.admin')

@section('content')
    <div>
        <div class="d-flex">
            <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                <div>
                    @can('MetaController.create')
                    <a href="{{ route('admin.seo.meta.create') }}" class="btn btn-primary">
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
                <th scope="col" class="col-1">{{ __('Danh mục') }}</th>
                <th scope="col" class="col-2">{{ __('Khoảng giá') }}</th>
                <th scope="col" class="col-2">{{ __('Tiêu đề') }}</th>
                <th scope="col" class="col-3">{{ __('Thẻ H1') }}</th>
                <th scope="col" class="col-3">{{ __('Mô tả') }}</th>
                <th scope="col" class="col-1">{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($seo_sims as $sim)
                <tr>
                    <td>
                        @if($sim->sim_type != null)
                            {{ $sim->sim_type_name['name'] }}
                        @else
                            Tất cả loại sim
                        @endif

                    </td>
                    <td>
                        @if($sim->price_max != null)
                        {{ number_format($sim->price_min) }} - {{ number_format($sim->price_max) }}
                        @else
                        {{ number_format($sim->price_min) }} - Không giới hạn giá
                        @endif
                    </td>
                    <td>{{ $sim->title }}</td>
                    <td>{{ $sim->h1 }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($sim->description, 30, '...') }}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('admin.seo.meta.edit',[$sim->id]) }}" class="btn btn-sm btn-outline-warning me-2">{{ __('Xem') }}</a>
                            @can('MetaController.destroy')
                                <form action="{{ route('admin.seo.meta.destroy',[$sim->id]) }}" method="post" onsubmit="javascript: return confirm('{{ __('Thao tác không thể phục hồi, bạn chắc chắn muốn xóa?') }}')">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">{{ __('Xóa') }}</button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">{{ __('Không có bản ghi') }}</td>
                </tr>
            @endforelse
            </tbody>
            <caption>
                {{ $seo_sims->withQueryString()->links() }}
            </caption>
        </table>
    </div>
@endsection

