@extends('layouts.admin')
@section('content')
    <div>
        <form action="{{ route('admin.setting.update',[$group]) }}" method="POST" autocomplete="off">
            @csrf
            <div class="d-flex mb-3 pb-3 border-bottom">
                <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                    @can('SettingController.update')<button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                        </svg>
                        {{ __('Lưu') }}
                    </button>
                    @endif
                </div>
                <nav class="nav nav-pills nav-fill" style="--bs-nav-link-font-weight: normal">
                    <a style="--bs-nav-pills-link-active-bg: #ffc107;--bs-nav-pills-link-active-color: #000000" class="nav-link active" aria-current="page" href="{{ route('admin.setting.index',['group'=>'index']) }}">{{ __('Cài đặt chung') }}</a>
                    <a class="nav-link" href="{{ route('admin.setting.index',['group'=>'blog']) }}">{{ __('Cài đặt tin tức') }}</a>
                </nav>
            </div>
            <fieldset>
                <legend>{{ __('Cài đặt chung') }}:</legend>
                @foreach ($generalSetting->field_set as $field => $label)
                    <div class="mb-3">
                        <label for="{{ $field }}" class="form-label fw-bold">{{ $label->text }}</label>
                        @if (isset($label->textarea))
                            <textarea class="form-control" id="{{ $field }}"
                                name="{{ "{$generalSetting->field_value->group()}[{$field}]" }}" @cannot('SettingController.update') disabled @endif>{{ $generalSetting->field_value->$field }}</textarea>
                        @else
                            <div class="input-group">
                                <span class="input-group-text">{!! $label->icon !!}</span>
                                <input type="text" class="form-control" id="{{ $field }}"
                                    name="{{ "{$generalSetting->field_value->group()}[{$field}]" }}"
                                    value="{{ $generalSetting->field_value->$field }}" required @cannot('SettingController.update') disabled @endif>
                            </div>
                        @endif
                    </div>
                @endforeach
            </fieldset>
            <fieldset>
                <legend>{{ __('Cài đặt Hotline') }}:</legend>
                @foreach ($hotlineSetting->field_set as $field => $label)
                    <div class="mb-3">
                        <label for="{{ $field }}" class="form-label fw-bold">{{ $label->text }}</label>
                        <div class="input-group">
                            <span class="input-group-text">{!! $label->icon !!}</span>
                            <input type="text" class="form-control" id="{{ $field }}"
                                name="{{ "{$hotlineSetting->field_value->group()}[{$field}]" }}"
                                value="{{ $hotlineSetting->field_value->$field }}" required @cannot('SettingController.update') disabled @endif>
                        </div>
                    </div>
                @endforeach
            </fieldset>
        </form>
    </div>
@endsection
