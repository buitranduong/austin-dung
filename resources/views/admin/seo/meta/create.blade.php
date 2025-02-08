@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('static/css/select2.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.seo.meta.store') }}" method="POST" accept-charset="utf-8">
            @csrf
            <div class="d-flex pb-3 border-bottom">
                <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                    <a href="{{ route('admin.seo.meta.index') }}" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                        </svg>
                        {{ __('Hủy') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy-fill" viewBox="0 0 16 16">
                            <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z"/>
                            <path d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z"/>
                        </svg>
                        {{ __('Lưu') }}
                    </button>
                </div>
            </div>
            <div class="mt-3">
                <div class="mb-3">
                    <label for="sim_type" class="form-label fw-bold">{{ __('Loại sim') }}</label>
                    <select id="sim_type" name="sim_type" class="form-select form-select-sm select2" aria-label="Small select example">
                        <option value="" selected >{{ __('Tất cả loại sim') }}</option>
                        @foreach($sim_types as $type)
                            <option value="{{ $type['id'] }}" @if(old('sim_type') == $type['id']) selected @endif>{{ $type['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="price_min" class="form-label fw-bold">{{ __('Giá thấp nhất') }}</label>
                    <select id="price_min" name="price_min" class="form-select form-select-sm select2 @error('price_min') is-invalid @enderror" aria-label="Small select example">
                        @foreach($sim_price_min as $value=>$label)
                            <option value="{{ $value }}" @if(old('price_min') == $value) selected @endif>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('price_min')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="price_max" class="form-label fw-bold">{{ __('Giá cao nhất') }}</label>
                    <select id="price_max" name="price_max" class="form-select form-select-sm select2 @error('price_max') is-invalid @enderror" aria-label="Small select example">
                        @foreach($sim_price_max as $value=>$label)
                            <option value="{{ $value }}" @if(old('price_max') == $value) selected @endif>{{ $label }}</option>
                        @endforeach
                        <option value= "">{{ __('Không giới hạn giá') }}</option>
                    </select>
                    @error('price_max')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">{{ __('Tiêu đề') }}</label>
                    <input aria-describedby="titleHelp" class="form-control @error('title') is-invalid @enderror" type="text" id="title" name="title" value="{{ old('title') }}">
                    <div id="titleHelp" class="form-text fst-italic text-danger-emphasis">Lưu ý: {{ __('Tiêu đề') }} không được dài quá 255 ký tự</div>
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="h1" class="form-label fw-bold">{{ __('Thẻ H1') }}</label>
                    <input aria-describedby="h1Help" class="form-control @error('h1') is-invalid @enderror" type="text" id="h1" name="h1" value="{{old('h1') }}">
                    <div id="h1Help" class="form-text fst-italic text-danger-emphasis">Lưu ý: {{ __('Thẻ H1') }} không được dài quá 255 ký tự</div>
                    @error('h1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">{{ __('Mô tả') }}</label>
                    <textarea id="description" name="description" class="form-control" style="height: 150px">{{ old('description') }}</textarea>
                </div>
            </div>
        </form>
        <x-admin.sim-help/>
    </div>
@endsection

@section('script')
    <script src="{{ asset('static/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
@endsection
