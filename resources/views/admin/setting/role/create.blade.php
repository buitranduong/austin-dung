@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.role.store') }}" method="POST">
            @csrf
            <div class="d-flex mb-3 pb-3 border-bottom">
                <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                    <a href="{{ route('admin.role.index') }}" class="btn btn-secondary">{{ __('Hủy') }}</a>
                    <button type="submit" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                        </svg>
                        {{ __('Lưu') }}
                    </button>
                </div>
            </div>
            <div>
                <div class="mb-5">
                    <label for="name" class="form-label fw-bold">{{ __('Tên nhóm') }}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                           aria-describedby="nameHelp" required>
                    <div id="nameHelp" class="form-text fst-italic text-danger-emphasis">Lưu ý: Tên nhóm không được dài
                        quá 255 ký tự
                    </div>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-5">
                        <h5>{{ __('Quyền chức năng') }}</h5>
                        <select id="undo_redo" class="form-control" size="13" multiple="multiple">
                            @foreach($permissions as $controller=>$actions)
                                <optgroup label="{{ $actions['__construct'] }}">
                                    @foreach($actions as $method=>$action)
                                        @if($method != '__construct')
                                            @if(!in_array("{$controller}.{$method}", $assigned))
                                                <option value="{{ "{$controller}.{$method}" }}">{{ $action }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-2 mt-4">
                        <div class="d-flex flex-column gap-3">
                            <button type="button" id="undo_redo_undo" class="btn btn-primary w-100">undo</button>
                            <button type="button" id="undo_redo_rightAll" class="btn btn-secondary w-100"><i
                                    class="bi bi-chevron-double-right"></i></button>
                            <button type="button" id="undo_redo_rightSelected" class="btn btn-secondary w-100"><i
                                    class="bi bi-chevron-right"></i></button>
                            <button type="button" id="undo_redo_leftSelected" class="btn btn-secondary w-100"><i
                                    class="bi bi-chevron-left"></i></button>
                            <button type="button" id="undo_redo_leftAll" class="btn btn-secondary w-100"><i
                                    class="bi bi-chevron-double-left"></i></button>
                            <button type="button" id="undo_redo_redo" class="btn btn-warning w-100">redo</button>
                        </div>
                    </div>

                    <div class="col-5">
                        <h5>{{ __('Quyền cho phép') }}</h5>
                        <select name="permissions[]" id="undo_redo_to" class="form-control" size="13"
                                multiple="multiple">
                            @foreach($permissions as $controller=>$actions)
                              
                                    @foreach($actions as $method=>$action)
                                        @if($method != '__construct')
                                            @if(in_array("{$controller}.{$method}", $assigned))
                                                <option
                                                    value="{{ "{$controller}.{$method}" }}">{{ $action }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('static/js/multiselect.min.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('#undo_redo').multiselect({
                search: {
                    left: '<input type="text" name="q" class="form-control" placeholder="{{ __('Tìm kiếm') }}..." />',
                    right: '<input type="text" name="q" class="form-control" placeholder="{{ __('Tìm kiếm') }}..." />',
                },
                fireSearch: function (value) {
                    return value.length > 0;
                }
            });
        });
    </script>
@endsection
