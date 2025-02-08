@extends('layouts.admin')
@section('content')
    <div>
        <form action="{{ route('admin.setting.redirect.update') }}" method="POST" autocomplete="off">
            @csrf
            <div class="d-flex mb-3 pb-3 border-bottom">
                <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                    @can('SettingController.redirect')
                        <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                            </svg>
                            {{ __('Lưu') }}
                        </button>
                    @endif
                </div>
            </div>
            <fieldset>
                <legend>{{ __('Cài đặt chuyển hướng') }}:</legend>
                @php($count = count($redirectSetting->url_array))
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="url_array[{{ $count }}][from]"/>
                        <span class="input-group-text"><i class="bi bi-arrow-right"></i></span>
                        <select class="form-select flex-grow-0" style="width: 80px" name="url_array[{{ $count }}][code]">
                            <option value="301">301</option>
                            <option value="302">302</option>
                            <option value="404">404</option>
                        </select>
                        <span class="input-group-text"><i class="bi bi-arrow-right"></i></span>
                        <input type="text" class="form-control" name="url_array[{{ $count }}][to]"/>
                    </div>
                </div>
                @foreach($redirectSetting->url_array as $i=>$item)
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ $item['from'] }}" name="url_array[{{ $i }}][from]"/>
                            <span class="input-group-text"><i class="bi bi-arrow-right"></i></span>
                            <select class="form-select flex-grow-0" style="width: 80px" name="url_array[{{ $i }}][code]">
                                <option value="301" @selected($item['code'] == 301)>301</option>
                                <option value="302" @selected($item['code'] == 302)>302</option>
                                <option value="404" @selected($item['code'] == 404)>404</option>
                            </select>
                            <span class="input-group-text"><i class="bi bi-arrow-right"></i></span>
                            <input type="text" class="form-control" value="{{ $item['to'] }}" name="url_array[{{ $i }}][to]"/>
                        </div>
                    </div>
                @endforeach
            </fieldset>
        </form>
    </div>
@endsection
