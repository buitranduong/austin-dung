@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('static/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/select2.min.css') }}">
@endsection

@section('preload')
    <x-admin.offcanvas style="--bs-offcanvas-width: 700px" title="{{ __('Seo Meta') }}" scroll="true" backdrop="false" id="offcanvasSeo">
        <x-admin.seo-meta :meta_data="$meta_data" :related_content='$page->related_content' :head_script_before="$page->head_script_before" :head_script_after="$page->head_script_after" :body_script_before="$page->body_script_before"
            :body_script_after="$page->body_script_after" action="{{ route('admin.seo.page.seo-meta', [$page->id]) }}">
            <x-slot:after>
                <div class="mb-3">
                    <label for="seo-keywords" class="form-label fw-bold">{{ __('Link sản phẩm') }}</label>
                    <input class="form-control" name="schema_product" value="{{$page->schema_product}}">
                </div>
                <div class="accordion" id="accordionFAQ">
                @for ($i = 0; $i < 10; $i++)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button @if(!empty($page->faq[$i]['question'])) text-danger @endif {{ !$i?:'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}" aria-expanded="true" aria-controls="collapseOne">
                                FAQ Item #{{ $i+1 }}
                            </button>
                        </h2>
                        <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i?:'show' }}" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body" style="--bs-accordion-body-padding-y:0;--bs-accordion-body-padding-x:1rem;">
                                <div class="mt-3">
                                    <label for="question{{ $i }}" class="form-label">{{ __('Câu hỏi') }} {{ $i+1 }}</label>
                                    <input id="question{{ $i }}" type="text" class="form-control @error('question.' . ($i)) is-invalid @enderror"
                                           name="question[{{ $i}}]"
                                           value="{{ old('question.' . ($i)) ?? ($page->faq[$i]['question'] ?? '') }}">
                                    @error('question.' . ($i))
                                    <span class="error-message text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="url{{ $i }}" class="form-label">{{ __('Link') }} {{ $i+1 }}</label>
                                    <input id="url{{ $i }}" type="text" class="form-control @error('url.' . ($i)) is-invalid @enderror"
                                           name="url[{{ $i}}]"
                                           value="{{ old('url.' . ($i)) ?? ($page->faq[$i]['url'] ?? '') }}">
                                    @error('url.' . ($i))
                                    <span class="error-message text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="answer{{ $i }}" class="form-label">{{ __('Câu trả lời') }} {{ $i+1 }}</label>
                                    <textarea id="answer{{ $i }}" class="form-control mini-editor @error('answer.' . ($i)) is-invalid @enderror" name="answer[{{ $i }}]">{!! old('answer.' . ($i)) ?? ($page->faq[$i]['answer'] ?? '') !!}</textarea>
                                    @error('answer.' . ($i))
                                    <span class="error-message text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
                </div>
                <div class="d-flex mt-3 pt-3 border-top">
                    <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                        <button type="submit" class="btn btn-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-floppy-fill" viewBox="0 0 16 16">
                                <path
                                    d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z" />
                                <path
                                    d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z" />
                            </svg>
                            {{ __('Lưu') }}
                        </button>
                    </div>
                </div>
            </x-slot:after>
        </x-admin.seo-meta>
    </x-admin.offcanvas>
    <x-admin.offcanvas title="{{ __('Cấu hình Sim') }}" scroll="true" backdrop="false" id="offcanvasSim">
        <x-admin.sim-setting :sim_setting="$sim_setting" :sorts="$sorts" :providers="$providers"
            action="{{ route('admin.seo.page.sim-setting', [$page->id]) }}">
            <x-slot:after>
                <div class="d-flex mt-3 pt-3 border-top">
                    <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                        <button type="submit" class="btn btn-info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-floppy-fill" viewBox="0 0 16 16">
                                <path
                                    d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z" />
                                <path
                                    d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z" />
                            </svg>
                            {{ __('Lưu') }}
                        </button>
                    </div>
                </div>
            </x-slot:after>
        </x-admin.sim-setting>
    </x-admin.offcanvas>
@endsection

@section('content')
    <div>
        <form action="{{ route('admin.seo.page.update', [$page->id]) }}" method="POST" accept-charset="utf-8"
            enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="d-flex pb-3 border-bottom">
                <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                    <a href="{{ session('previous_url', route('admin.seo.page.index')) }}" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                        </svg>
                        {{ __('Hủy') }}
                    </a>
                    @can('SeoController.edit')
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-floppy-fill" viewBox="0 0 16 16">
                            <path
                                d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z" />
                            <path
                                d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z" />
                        </svg>
                        {{ __('Lưu') }}
                    </button>
                    @endif
                </div>
                <div class="d-inline-flex gap-1">
                    @can('SeoController.seoMeta')
                    <a href="#offcanvasSeo" data-bs-toggle="offcanvas" role="button" class="btn btn-warning"
                        aria-controls="offcanvasSeo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-browser-chrome" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M16 8a8 8 0 0 1-7.022 7.94l1.902-7.098a3 3 0 0 0 .05-1.492A3 3 0 0 0 10.237 6h5.511A8 8 0 0 1 16 8M0 8a8 8 0 0 0 7.927 8l1.426-5.321a3 3 0 0 1-.723.255 3 3 0 0 1-1.743-.147 3 3 0 0 1-1.043-.7L.633 4.876A8 8 0 0 0 0 8m5.004-.167L1.108 3.936A8.003 8.003 0 0 1 15.418 5H8.066a3 3 0 0 0-1.252.243 2.99 2.99 0 0 0-1.81 2.59M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                        </svg>
                        {{ __('Seo Meta') }}
                    </a>
                    @endif
                    @can('SeoController.simSetting')
                    <a href="#offcanvasSim" data-bs-toggle="offcanvas" role="button" class="btn btn-info"
                        aria-controls="offcanvasSim">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-sd-card-fill" viewBox="0 0 16 16">
                            <path
                                d="M12.5 0H5.914a1.5 1.5 0 0 0-1.06.44L2.439 2.853A1.5 1.5 0 0 0 2 3.914V14.5A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 12.5 0m-7 2.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75m2 0a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75m2.75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 1.5 0m1.25-.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75" />
                        </svg>
                        {{ __('Cấu hình Sim') }}
                    </a>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-9 pt-3 border-end">
                    <div class="mb-3">
                        <label for="title" class="form-label">{{ __('Tiêu đề H1') }}</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" value="{{ $page->title }}" aria-describedby="titleHelp" required @cannot('SeoController.edit') disabled @endif>
                        <div id="titleHelp" class="form-text fst-italic text-danger-emphasis">Lưu ý:
                            {{ __('Tiêu đề H1') }}
                            không được dài quá 255 ký tự</div>
                        @error('title')
                            <span class="error-message text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="h2" class="form-label">{{ __('H2') }}</label>
                        <input id="h2" type="text" class="form-control @error('h2') is-invalid @enderror"
                            name="h2" value="{{ $page->h2 }}" aria-describedby="h2Help" required @cannot('SeoController.edit') disabled @endif >
                        <div id="h2Help" class="form-text fst-italic text-danger-emphasis">Lưu ý: {{ __('H2') }}
                            không được dài quá 255 ký tự</div>
                        @error('h2')
                            <span class="error-message text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">{{ __('Slug') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">{{ url('/') }}</span>
                            <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror"
                                name="slug" value="{{ $page->slug }}" aria-describedby="slugHelp" required @cannot('SeoController.edit') disabled @endif>
                            <span class="input-group-text">
                                <a href="{{ url($page->slug) }}" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-browser-safari" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.25-14.75v1.5a.25.25 0 0 1-.5 0v-1.5a.25.25 0 0 1 .5 0m0 12v1.5a.25.25 0 1 1-.5 0v-1.5a.25.25 0 1 1 .5 0M4.5 1.938a.25.25 0 0 1 .342.091l.75 1.3a.25.25 0 0 1-.434.25l-.75-1.3a.25.25 0 0 1 .092-.341m6 10.392a.25.25 0 0 1 .341.092l.75 1.299a.25.25 0 1 1-.432.25l-.75-1.3a.25.25 0 0 1 .091-.34ZM2.28 4.408l1.298.75a.25.25 0 0 1-.25.434l-1.299-.75a.25.25 0 0 1 .25-.434Zm10.392 6 1.299.75a.25.25 0 1 1-.25.434l-1.3-.75a.25.25 0 0 1 .25-.434ZM1 8a.25.25 0 0 1 .25-.25h1.5a.25.25 0 0 1 0 .5h-1.5A.25.25 0 0 1 1 8m12 0a.25.25 0 0 1 .25-.25h1.5a.25.25 0 1 1 0 .5h-1.5A.25.25 0 0 1 13 8M2.03 11.159l1.298-.75a.25.25 0 0 1 .25.432l-1.299.75a.25.25 0 0 1-.25-.432Zm10.392-6 1.299-.75a.25.25 0 1 1 .25.433l-1.3.75a.25.25 0 0 1-.25-.434ZM4.5 14.061a.25.25 0 0 1-.092-.341l.75-1.3a.25.25 0 0 1 .434.25l-.75 1.3a.25.25 0 0 1-.342.091m6-10.392a.25.25 0 0 1-.091-.342l.75-1.299a.25.25 0 1 1 .432.25l-.75 1.3a.25.25 0 0 1-.341.09ZM6.494 1.415l.13.483a.25.25 0 1 1-.483.13l-.13-.483a.25.25 0 0 1 .483-.13M9.86 13.972l.13.483a.25.25 0 1 1-.483.13l-.13-.483a.25.25 0 0 1 .483-.13M3.05 3.05a.25.25 0 0 1 .354 0l.353.354a.25.25 0 0 1-.353.353l-.354-.353a.25.25 0 0 1 0-.354m9.193 9.193a.25.25 0 0 1 .353 0l.354.353a.25.25 0 1 1-.354.354l-.353-.354a.25.25 0 0 1 0-.353M1.545 6.01l.483.13a.25.25 0 1 1-.13.483l-.483-.13a.25.25 0 1 1 .13-.482Zm12.557 3.365.483.13a.25.25 0 1 1-.13.483l-.483-.13a.25.25 0 1 1 .13-.483m-12.863.436a.25.25 0 0 1 .176-.306l.483-.13a.25.25 0 1 1 .13.483l-.483.13a.25.25 0 0 1-.306-.177m12.557-3.365a.25.25 0 0 1 .176-.306l.483-.13a.25.25 0 1 1 .13.483l-.483.13a.25.25 0 0 1-.306-.177M3.045 12.944a.3.3 0 0 1-.029-.376l3.898-5.592a.3.3 0 0 1 .062-.062l5.602-3.884a.278.278 0 0 1 .392.392L9.086 9.024a.3.3 0 0 1-.062.062l-5.592 3.898a.3.3 0 0 1-.382-.034zm3.143 1.817a.25.25 0 0 1-.176-.306l.129-.483a.25.25 0 0 1 .483.13l-.13.483a.25.25 0 0 1-.306.176M9.553 2.204a.25.25 0 0 1-.177-.306l.13-.483a.25.25 0 1 1 .483.13l-.13.483a.25.25 0 0 1-.306.176" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                        <div id="slugHelp" class="form-text fst-italic text-danger-emphasis">Lưu ý: {{ __('Slug') }}
                            không được dài quá 255 ký tự</div>
                        @error('slug')
                            <span class="error-message text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="editor" class="form-label">{{ __('Mô tả ngắn') }}</label>
                        <textarea name="excerpt" class="form-control" @cannot('SeoController.edit') disabled @endif>{!! $page->excerpt !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editor" class="form-label">{{ __('Nội dung') }}</label>
                        <textarea id="editor" name="content" class="form-control">{!! $page->content !!}</textarea>
                    </div>
                </div>
                <div class="col-3 pt-3">
                    <div id="sticky-box">
                        <div class="card">
                            <div class="card-header fw-bold">
                                {{ __('Hiển thị') }}
                            </div>
                            <div class="card-body">
                                <div class="mb-3 d-flex gap-2 align-items-center">
                                    <label for="author" class="form-label m-0">{{ __('Đăng bởi') }}:</label>
                                    <div class="flex-grow-1">
                                        <div class="input-group input-group-sm">
                                            <input id="author" type="text" class="form-control"
                                                value="{{ $page->createdByUser->name }}" disabled @cannot('SeoController.edit') disabled @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex gap-2 align-items-center">
                                    <label for="published_at" class="form-label m-0">{{ __('Thời gian') }}:</label>
                                    <div class="flex-grow-1">
                                        <div class="input-group input-group-sm">
                                            <input id="published_at" name="published_at" type="text"
                                                value="{{ optional($page->published_at)->format('Y-m-d H:i:s') }}"
                                                class="form-control" aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-sm" @cannot('SeoController.edit') disabled @endif>
                                            <span class="input-group-text" id="inputGroup-sizing-sm"><i
                                                    class="bi bi-calendar-date"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex align-items-center gap-2">
                                    <label for="status" class="form-label m-0">{{ __('Trạng thái') }}:</label>
                                    <div class="flex-grow-1">
                                        <select id="status" name="status" class="form-select form-select-sm"
                                            aria-label="Small select example" @cannot('SeoController.edit') disabled @endif>
                                            @foreach ($status as $value => $label)
                                                <option value="{{ $value }}"
                                                    @if ($page->status->value == $value) selected @endif>{{ __($label) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <label class="form-check-label" for="sticky">{{ __('Ghim bài viết') }}</label>
                                        <input class="form-check-input" type="checkbox" role="switch" id="sticky"
                                            name="featured" value="1"
                                            @if ($page->featured) checked @endif @cannot('SeoController.edit') disabled @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header fw-bold">
                                {{ __('Ảnh đại diện') }}
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="input-group custom-file-button">
                                        <label class="input-group-text" for="featured_image">{{ __('Chọn ảnh') }}</label>
                                        <input name="featured_image" accept=".jpg,.jpeg,.png,.webp,.gif"
                                            class="form-control" type="file" id="featured_image" @cannot('SeoController.edit') disabled @endif>
                                    </div>
                                    @if (!empty($page->featured_image))
                                        <img src="{{ asset_image($page->featured_image) }}" id="featured_image_thumbnail"
                                            width="100%" height="auto" alt="">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-3 pt-3 border-top">
                            <div>
                                @can('SeoController.edit')
                                <button type="submit" class="btn btn-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-send-check-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 1.59 2.498C8 14 8 13 8 12.5a4.5 4.5 0 0 1 5.026-4.47zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z" />
                                        <path
                                            d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686" />
                                    </svg>
                                    {{ __('Đăng') }}
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('static/js/jquery.stickybox.js') }}"></script>
    <script src="{{ asset('static/js/select2.min.js') }}"></script>
    <script src="{{ asset('static/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('static/js/jquery.inputmask.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('input[name="published_at"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                timePicker: true,
                timePicker24Hour: false,
                locale: {
                    format: 'YYYY-MM-DD HH:mm:ss'
                }
            });
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
            $('#sticky-box').stickyBox({spaceTop:70});
            $("input[inputmode=\"decimal\"]").inputmask("decimal", {
                rightAlign: false,
                groupSeparator: ',',
                radixPoint: '.',
                removeMaskOnSubmit: true
            });
        });
    </script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route('admin.seo.page.upload') }}');
                var token = '{{ csrf_token() }}';
                xhr.setRequestHeader("X-CSRF-Token", token);
                xhr.upload.onprogress = (e) => {
                    progress(e.loaded / e.total * 100);
                };

                xhr.onload = () => {
                    if (xhr.status === 403) {
                        reject({
                            message: 'HTTP Error: ' + xhr.status,
                            remove: true
                        });
                        return;
                    }

                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }

                    const json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        reject('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    resolve(json.location);
                };

                xhr.onerror = () => {
                    reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                };

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());

                xhr.send(formData);
            });

            tinymce.init({
                selector: 'textarea#editor',
                plugins: 'advlist anchor autolink autoresize autosave charmap code codesample directionality emoticons fullscreen help image importcss insertdatetime link lists media nonbreaking pagebreak preview quickbars save searchreplace table visualblocks visualchars wordcount',
                toolbar: 'undo redo | blocks | bold italic | alignleft aligncentre alignright alignjustify | indent outdent | bullist numlist | blockquote',
                height: 500,
                min_height: 500,
                image_title: true,
                images_reuse_filename: true,
                automatic_uploads: true,
                file_picker_types: 'image',
                promotion: false,
                statusbar: true,
                toolbar_sticky: true,
                toolbar_sticky_offset: 57,
                license_key: 'gpl',
                relative_urls: true,
                remove_script_host: false,
                convert_urls: true,
                document_base_url: '{{ asset('/') }}',
                entity_encoding: "raw",
                image_caption: true,
                images_upload_handler: example_image_upload_handler,
                readonly: {{ Auth::user()->can('SeoController.edit') ? 'false' : 'true' }}
            });
            tinymce.init({
                selector: 'textarea.mini-editor',
                height: 300,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
                    'insertdatetime', 'media', 'wordcount'
                ],
                menubar: 'edit insert view format tools',
                toolbar: '',
                license_key: 'gpl',
                promotion: false,
                entity_encoding : "raw",
                statusbar: false
            });
        });

        const convertBase64 = (file) => {
            return new Promise((resolve, reject) => {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(file);

                fileReader.onload = () => {
                    resolve(fileReader.result);
                };

                fileReader.onerror = (error) => {
                    reject(error);
                };
            });
        };

        const uploadImage = async (event) => {
            const file = event.target.files[0];
            const base64 = await convertBase64(file);
            document.getElementById("featured_image_thumbnail").src = base64;
        };

        document.getElementById("featured_image").addEventListener("change", (e) => {
            uploadImage(e);
        });
    </script>
@endsection
