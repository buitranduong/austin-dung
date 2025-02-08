@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('static/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/select2.min.css') }}">
@endsection
@section('preload')
    <x-admin.offcanvas title="{{ __('Seo Meta') }}" scroll="true" backdrop="false" id="offcanvasSeo">
        <x-admin.seo-meta :meta_data="$meta_data" :related_content='$post->related_content' :head_script_before="$post->head_script_before" :head_script_after="$post->head_script_after" :body_script_before="$post->body_script_before"
            :body_script_after="$post->body_script_after" action="{{ route('admin.post.seo-meta', [$post->id]) }}">
            <x-slot:after>
                <div class="d-flex mt-3 pt-3 border-top">
                    <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
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
                    </div>
                </div>
            </x-slot:after>
        </x-admin.seo-meta>
    </x-admin.offcanvas>
    <x-admin.offcanvas title="{{ __('Thêm mới chuyên mục') }}" id="offcanvasCategory">
        <x-admin.category.form :categories="$categories">
            <x-slot:after>
                <div class="d-flex mt-3 pt-3 border-top">
                    <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
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
                    </div>
                </div>
                <input type="hidden" name="redirect" value="{{ route('admin.post.edit', [$post->id]) }}" />
            </x-slot:after>
        </x-admin.category.form>
    </x-admin.offcanvas>
    <x-admin.offcanvas title="{{ __('Thêm mới thẻ') }}" id="offcanvasTags">
        <x-admin.category.tags>
            <x-slot:after>
                <div class="d-flex mt-3 pt-3 border-top">
                    <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
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
                    </div>
                </div>
                <input type="hidden" name="redirect" value="{{ route('admin.post.edit', [$post->id]) }}" />
            </x-slot:after>
        </x-admin.category.tags>
    </x-admin.offcanvas>
@endsection

@section('content')
    {!! $errors->first() !!}
    <div>
        <form action="{{ route('admin.post.update', [$post->id]) }}" method="POST" accept-charset="utf-8"
            enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="d-flex pb-3 border-bottom">
                <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                    <a href="{{ session('previous_url', route('admin.post.index')) }}" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                        </svg>
                        {{ __('Hủy') }}
                    </a>
                    @can('PostController.seoMeta')
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
                <div>
                    @can('PostController.seoMeta')
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
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-9 col-xl-8 pt-3 border-end">
                    <div class="mb-3">
                        <label for="title" class="form-label">{{ __('Tiêu đề') }}</label>
                        <input id="title" type="text" class="form-control" name="title"
                            value="{{ $post->title }}" required  @cannot('PostController.edit')disabled @endif>
                        @if ($errors->has('title'))
                            <span class="error-message text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">{{ __('Slug') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon3">{{ url('/bai-viet') }}/</span>
                            <input type="text" class="form-control" name="slug" value="{{ $post->slug }}"
                                id="slug" aria-describedby="basic-addon3" @cannot('PostController.edit')disabled @endif>
                            <span class="input-group-text">
                                <a href="{{ route('blog.post', [$post->slug]) }}" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-browser-safari" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.25-14.75v1.5a.25.25 0 0 1-.5 0v-1.5a.25.25 0 0 1 .5 0m0 12v1.5a.25.25 0 1 1-.5 0v-1.5a.25.25 0 1 1 .5 0M4.5 1.938a.25.25 0 0 1 .342.091l.75 1.3a.25.25 0 0 1-.434.25l-.75-1.3a.25.25 0 0 1 .092-.341m6 10.392a.25.25 0 0 1 .341.092l.75 1.299a.25.25 0 1 1-.432.25l-.75-1.3a.25.25 0 0 1 .091-.34ZM2.28 4.408l1.298.75a.25.25 0 0 1-.25.434l-1.299-.75a.25.25 0 0 1 .25-.434Zm10.392 6 1.299.75a.25.25 0 1 1-.25.434l-1.3-.75a.25.25 0 0 1 .25-.434ZM1 8a.25.25 0 0 1 .25-.25h1.5a.25.25 0 0 1 0 .5h-1.5A.25.25 0 0 1 1 8m12 0a.25.25 0 0 1 .25-.25h1.5a.25.25 0 1 1 0 .5h-1.5A.25.25 0 0 1 13 8M2.03 11.159l1.298-.75a.25.25 0 0 1 .25.432l-1.299.75a.25.25 0 0 1-.25-.432Zm10.392-6 1.299-.75a.25.25 0 1 1 .25.433l-1.3.75a.25.25 0 0 1-.25-.434ZM4.5 14.061a.25.25 0 0 1-.092-.341l.75-1.3a.25.25 0 0 1 .434.25l-.75 1.3a.25.25 0 0 1-.342.091m6-10.392a.25.25 0 0 1-.091-.342l.75-1.299a.25.25 0 1 1 .432.25l-.75 1.3a.25.25 0 0 1-.341.09ZM6.494 1.415l.13.483a.25.25 0 1 1-.483.13l-.13-.483a.25.25 0 0 1 .483-.13M9.86 13.972l.13.483a.25.25 0 1 1-.483.13l-.13-.483a.25.25 0 0 1 .483-.13M3.05 3.05a.25.25 0 0 1 .354 0l.353.354a.25.25 0 0 1-.353.353l-.354-.353a.25.25 0 0 1 0-.354m9.193 9.193a.25.25 0 0 1 .353 0l.354.353a.25.25 0 1 1-.354.354l-.353-.354a.25.25 0 0 1 0-.353M1.545 6.01l.483.13a.25.25 0 1 1-.13.483l-.483-.13a.25.25 0 1 1 .13-.482Zm12.557 3.365.483.13a.25.25 0 1 1-.13.483l-.483-.13a.25.25 0 1 1 .13-.483m-12.863.436a.25.25 0 0 1 .176-.306l.483-.13a.25.25 0 1 1 .13.483l-.483.13a.25.25 0 0 1-.306-.177m12.557-3.365a.25.25 0 0 1 .176-.306l.483-.13a.25.25 0 1 1 .13.483l-.483.13a.25.25 0 0 1-.306-.177M3.045 12.944a.3.3 0 0 1-.029-.376l3.898-5.592a.3.3 0 0 1 .062-.062l5.602-3.884a.278.278 0 0 1 .392.392L9.086 9.024a.3.3 0 0 1-.062.062l-5.592 3.898a.3.3 0 0 1-.382-.034zm3.143 1.817a.25.25 0 0 1-.176-.306l.129-.483a.25.25 0 0 1 .483.13l-.13.483a.25.25 0 0 1-.306.176M9.553 2.204a.25.25 0 0 1-.177-.306l.13-.483a.25.25 0 1 1 .483.13l-.13.483a.25.25 0 0 1-.306.176" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                        @if ($errors->has('slug'))
                            <span class="error-message text-danger">{{ $errors->first('slug') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="editor" class="form-label">{{ __('Nội dung') }}</label>
                        <textarea id="editor" name="content" class="form-control">{{ $post->content }}</textarea>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 pt-3">
                    <div id="sticky-box">
                        <div class="card">
                            <div class="card-header fw-bold d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCardShow" aria-expanded="true" aria-controls="collapseCardShow">
                                {{ __('Hiển thị') }}
                                <i class="collapseIcon bi bi-chevron-down"></i>
                            </div>
                            <div id="collapseCardShow" class="collapse show">
                                <div class="card-body custom-card-body">
                                    <div class="mb-3 d-flex gap-2 align-items-center">
                                        <label for="author" class="form-label m-0">{{ __('Đăng bởi') }}:</label>
                                        <div class="flex-grow-1">
                                            <select id="author" name="created_by" class="form-select form-select-sm" aria-label="Small select example" @cannot('PostController.edit')disabled @endif>
                                                @foreach ($authors as $user)
                                                    <option value="{{ $user->id }}" @if ($post->createdByUser->id == $user->id) selected @endif>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 d-flex gap-2 align-items-center">
                                        <label for="published_at" class="form-label m-0">{{ __('Thời gian') }}:</label>
                                        <div class="flex-grow-1">
                                            <div class="input-group input-group-sm">
                                                <input id="published_at" name="published_at" type="text" value="{{ optional($post->published_at)->format('Y-m-d H:i:s') }}" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" @cannot('PostController.edit')disabled @endif>
                                                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="bi bi-calendar-date"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 d-flex align-items-center gap-2">
                                        <label for="status" class="form-label m-0">{{ __('Trạng thái') }}:</label>
                                        <div class="flex-grow-1">
                                            <select id="status" name="status" class="form-select form-select-sm" aria-label="Small select example" @cannot('PostController.edit')disabled @endif>
                                                @foreach ($status as $value => $label)
                                                    <option value="{{ $value }}" @if ($post->status->value == $value) selected @endif>{{ __($label) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="sticky">{{ __('Ghim bài viết') }}</label>
                                            <input class="form-check-input" type="checkbox" role="switch" id="sticky" name="sticky" value="1" @if ($post->sticky) checked @endif @cannot('PostController.edit')disabled @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header fw-bold d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategoryTag" aria-expanded="true" aria-controls="collapseCategoryTag">
                                {{ __('Chuyên mục & Thẻ') }}
                                <i class="collapseIcon bi bi-chevron-down"></i>
                            </div>
                            <div id="collapseCategoryTag" class="collapse show">
                                <div class="card-body custom-card-body">
                                    <div class="mb-3">
                                        <div class="form-label">{{ __('Chuyên mục') }}:</div>
                                        <div>
                                            <div class="input-group input-group-sm">
                                                <select name="category_id" class="form-select form-select-sm select2" aria-label="Small select example" @cannot('PostController.edit')disabled @endif>
                                                    @foreach ($categories as $item)
                                                        <x-admin.category.option :category="$item" :selected="$post_category_id" />
                                                    @endforeach
                                                </select>
                                                <div class="input-group-text">
                                                    <a class="" data-bs-toggle="offcanvas" href="#offcanvasCategory" role="button" aria-controls="offcanvasCategory">
                                                        <i class="bi bi-plus-circle-fill"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-label">{{ __('Thẻ') }}:</div>
                                        <div>
                                            <div class="input-group input-group-sm">
                                                <select name="tags[]" multiple class="form-select form-select-sm select2" aria-label="Small select example" @cannot('PostController.edit')disabled @endif>
                                                    @foreach ($tags as $item)
                                                        <x-admin.category.option :tag="$item" :selected="$post_tags_id" />
                                                    @endforeach
                                                </select>
                                                <div class="input-group-text">
                                                    <a class="" data-bs-toggle="offcanvas" href="#offcanvasTags" role="button" aria-controls="offcanvasTags">
                                                        <i class="bi bi-plus-circle-fill"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header fw-bold d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImage" aria-expanded="false" aria-controls="collapseImage">
                                {{ __('Ảnh đại diện') }}
                                <i class="collapseIcon bi bi-chevron-down"></i>
                            </div>
                            <div id="collapseImage" class="collapse">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="input-group custom-file-button">
                                            <label class="input-group-text" for="featured_image_post">{{ __('Chọn ảnh') }}</label>
                                            <input onchange="uploadImage(this, 'thumb_post');" name="featured_image" accept=".jpg,.jpeg,.png,.webp,.gif" class="form-control" type="file" id="featured_image_post" @cannot('PostController.edit')disabled @endif>
                                        </div>
                                        <img id="featured_image_thumb_post" width="100%" height="auto" @if (isset($post->featured_image)) src="{{ url("storage/{$post->featured_image}") }}" @endif alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-3 pt-3 border-top">
                            <div class="flex-grow-1">
                                @can('PostController.edit')
                                <a href="{{ route('admin.post.create', ['id' => $post->id]) }}" class="btn btn-outline-secondary" onclick="return confirm('Bạn có chắc chắn muốn nhân bản bài viết này không?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                        <path
                                            d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9" />
                                        <path fill-rule="evenodd"
                                            d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z" />
                                    </svg>
                                    {{ __('Nhân bản') }}
                                </a>
                                @endif
                            </div>
                            <div>
                                @can('PostController.edit')
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
                                <input type="hidden" name="category" value="{{ $category }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('static/js/select2.min.js') }}"></script>
    <script src="{{ asset('static/js/jquery.stickybox.js') }}"></script>
    <script src="{{ asset('static/js/daterangepicker.js') }}"></script>
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
            $('#sticky-box').stickyBox({spaceTop:70});
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

            $('.collapse').on('show.bs.collapse', function () {
                $(this).parent().find('.collapseIcon').removeClass('bi-chevron-down').addClass('bi-chevron-up');
            });

            $('.collapse').on('hide.bs.collapse', function () {
                $(this).parent().find('.collapseIcon').removeClass('bi-chevron-up').addClass('bi-chevron-down');
            });
        });
    </script>
    <script src="{{ asset('static/js/tinymce.plugins.js') }}"></script>
    <script src="{{ asset('static/js/tinymce/plugins/btncopy/plugin.min.js') }}"></script>
    <script src="{{ asset('static/js/tinymce/plugins/listsim/plugin.min.js') }}"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route('admin.post.upload') }}');
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
                plugins: 'btn_copy custom_query advlist anchor autolink autoresize autosave charmap code codesample directionality emoticons fullscreen help image importcss insertdatetime link lists media nonbreaking pagebreak preview quickbars save searchreplace table visualblocks visualchars wordcount',
                toolbar: 'undo redo | blocks | bold italic | alignleft aligncentre alignright alignjustify | indent outdent | bullist numlist | blockquote | btn_copy custom_query',
                height: 500,
                min_height: 500,
                image_title: true,
                images_reuse_filename: true,
                automatic_uploads: true,
                file_picker_types: 'image',
                images_upload_url: '{{ route('admin.post.upload') }}',
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
                setup: function(editor) {
                    editor.on('PreInit', function() {
                        editor.parser.addNodeFilter('iframe', function(nodes) {
                            nodes.forEach(function(node) {
                                node.attr('sandbox', 'allow-scripts allow-same-origin');
                            });
                        });
                    });
                },
                images_upload_handler: example_image_upload_handler,
                readonly: {{ Auth::user()->can('PostController.edit') ? 'false' : 'true' }}
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
                statusbar: false
            });
        });

        function convertBase64(file) {
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
        }

        async function uploadImage(event, id) {
            const file = $(event)[0].files;
            const base64 = await convertBase64(file[0]);
            document.getElementById(`featured_image_${id}`).src = base64;
        }
    </script>
@endsection
