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
                    <a class="nav-link" href="{{ route('admin.setting.index',['group'=>'index']) }}">{{ __('Cài đặt chung') }}</a>
                    <a style="--bs-nav-pills-link-active-bg: #ffc107;--bs-nav-pills-link-active-color: #000000" class="nav-link active" aria-current="page" href="{{ route('admin.setting.index',['group'=>'blog']) }}">{{ __('Cài đặt tin tức') }}</a>
                </nav>
            </div>
            <div class="scroll-x">
                <fieldset>
                    <legend>{{ __('Cài đặt tin tức') }}:</legend>
                    @foreach ($blogSetting->field_set as $field => $label)
                        <div class="mb-3">
                            <label for="{{ $field }}" class="form-label fw-bold">{{ $label->text }}</label>
                            @if (isset($label->textarea))
                                <textarea class="form-control" id="{{ $field }}"
                                          name="{{ "{$blogSetting->field_value->group()}[{$field}]" }}" @cannot('SettingController.update') disabled @endif>{{ $blogSetting->field_value->$field }}</textarea>
                            @else
                                <div class="input-group">
                                    <span class="input-group-text">{!! $label->icon !!}</span>
                                    <input type="text" class="form-control" id="{{ $field }}"
                                           name="{{ "{$blogSetting->field_value->group()}[{$field}]" }}"
                                           value="{{ $blogSetting->field_value->$field }}" required @cannot('SettingController.update') disabled @endif>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </fieldset>
                <fieldset>
                    <legend>{{ __('Cài đặt ảnh') }}:</legend>
                    <div class="mb-3">
                        <div class="form-label">{{ __('Featured') }}</div>
                        <div class="input-group">
                            <span class="input-group-text">{{ __('Chiều rộng') }}</span>
                            <input type="text" class="form-control" name="{{ "{$imageSetting->group()}[width_featured]" }}" value="{{ $imageSetting->width_featured }}" disabled required @cannot('SettingController.update') disabled @endif>
                            <span class="input-group-text">px</span>
                            <span class="input-group-text">{{ __('Chiều cao') }}</span>
                            <input type="text" class="form-control" name="{{ "{$imageSetting->group()}[height_featured]" }}" value="{{ $imageSetting->height_featured }}" disabled required @cannot('SettingController.update') disabled @endif>
                            <span class="input-group-text">px</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-label">{{ __('Thumbnail') }}</div>
                        <div class="input-group">
                            <span class="input-group-text">{{ __('Chiều rộng') }}</span>
                            <input type="text" class="form-control" name="{{ "{$imageSetting->group()}[width_thumbnail]" }}" value="{{ $imageSetting->width_thumbnail }}" disabled required @cannot('SettingController.update') disabled @endif>
                            <span class="input-group-text">px</span>
                            <span class="input-group-text">{{ __('Chiều cao') }}</span>
                            <input type="text" class="form-control" name="{{ "{$imageSetting->group()}[height_thumbnail]" }}" value="{{ $imageSetting->height_thumbnail }}" disabled required @cannot('SettingController.update') disabled @endif>
                            <span class="input-group-text">px</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-label">{{ __('Small') }}</div>
                        <div class="input-group">
                            <span class="input-group-text">{{ __('Chiều rộng') }}</span>
                            <input type="text" class="form-control" name="{{ "{$imageSetting->group()}[width_small]" }}" value="{{ $imageSetting->width_small }}" disabled required @cannot('SettingController.update') disabled @endif>
                            <span class="input-group-text">px</span>
                            <span class="input-group-text">{{ __('Chiều cao') }}</span>
                            <input type="text" class="form-control" name="{{ "{$imageSetting->group()}[height_small]" }}" value="{{ $imageSetting->height_small }}" disabled required @cannot('SettingController.update') disabled @endif>
                            <span class="input-group-text">px</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-label">{{ __('Extension') }}</div>
                        <div class="input-group">
                            <span class="input-group-text">.</span>
                            <input type="text" class="form-control" name="{{ "{$imageSetting->group()}[extension]" }}" value="{{ $imageSetting->extension }}" disabled required>
                        </div>
                    </div>
                </fieldset>
            </div>
        </form>
    </div>
@endsection
