@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.user.update',[$user->id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="d-flex mb-3 pb-3 border-bottom">
                <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">{{ __('Hủy') }}</a>
                @can('UserController.edit')
                    <button type="submit" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                        </svg>
                        {{ __('Lưu') }}
                    </button>
                @endif
                </div>
            </div>
            <div>
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">{{ __('Họ và tên') }}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                           aria-describedby="nameHelp" required  @cannot('UserController.edit')disabled @endif>
                    <div id="nameHelp" class="form-text fst-italic text-danger-emphasis">Lưu ý: Tên không được dài
                        quá 255 ký tự
                    </div>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label fw-bold">{{ __('Slug') }}</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ $user->slug }}"
                           aria-describedby="slugHelp" required @cannot('UserController.edit')disabled @endif>
                    <div id="slugHelp" class="form-text fst-italic text-danger-emphasis">Lưu ý: {{ __('Slug') }} không được dài quá 100 ký tự và không có ký tự đặc biệt
                    </div>
                    @error('slug')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">{{ __('Email') }}</label>
                    <input autocomplete="none" type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                           aria-describedby="emailHelp" required @cannot('UserController.edit')disabled @endif>
                    <div id="emailHelp" class="form-text fst-italic text-danger-emphasis">Lưu ý: Email không được dài
                        quá 255 ký tự
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">{{ __('Mật khẩu') }}</label>
                    <input autocomplete="none" type="password" class="form-control" id="password" name="password" value=""
                           aria-describedby="passwordHelp" @cannot('UserController.edit')disabled @endif>
                    <div id="passwordHelp" class="form-text fst-italic text-danger-emphasis">Lưu ý: Mật khẩu ít nhất 6 ký tự không bao gồm khoảng trắng
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <div style="width: 200px">
                        <x-admin.image name="avatar" :src="$user->avatar"/>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label fw-bold">{{ __('Nhóm quyền') }}</label>
                    <select name="role" id="role" class="form-select" aria-label="Default select example" @cannot('UserController.edit')disabled @endif>
                        <option value="" disabled selected>{{ __('--- chọn một ---') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" @if($assigned && $role->id == $assigned->id) selected @endif>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="facebook" class="form-label fw-bold">{{ __('Facebook') }}</label>
                    <input class="form-control" name="facebook" value="{{ $user->facebook }}" @cannot('UserController.edit')disabled @endif>
                </div>
                <div class="mb-3">
                    <label for="x" class="form-label fw-bold">{{ __('X') }}</label>
                    <input class="form-control" name="x" value="{{ $user->x }}" @cannot('UserController.edit')disabled @endif>
                </div>
                <div class="mb-3">
                    <label for="youtube" class="form-label fw-bold">{{ __('Youtube') }}</label>
                    <input class="form-control" name="youtube" value="{{ $user->youtube }}" @cannot('UserController.edit')disabled @endif>
                </div>
                <div class="mb-3">
                    <label for="tiktok" class="form-label fw-bold">{{ __('Tiktok') }}</label>
                    <input class="form-control" name="tiktok" value="{{ $user->tiktok }}" @cannot('UserController.edit')disabled @endif>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">{{ __('Mô tả ngắn') }}</label>
                    <textarea class="form-control" name="description" @cannot('UserController.edit')disabled @endif>{{ $user->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label fw-bold">{{ __('Thông tin giới thiệu') }}</label>
                    <textarea id="editor"  class="form-control" name="content">{{ $user->content }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="head_script_before" class="form-label fw-bold">{{ __('Scrip head before') }}</label>
                    <textarea id="head_script_before" class="form-control" name="head_script_before">{!! $user->head_script_before !!}</textarea>
                </div>
                <div class="mb-3">
                    <label for="head_script_after" class="form-label fw-bold">{{ __('Scrip head after') }}</label>
                    <textarea id="head_script_after" class="form-control" name="head_script_after">{!!$user->head_script_after!!}</textarea>
                </div>
                <div class="mb-3">
                    <label for="body_script_before" class="form-label fw-bold">{{ __('Scrip body before') }}</label>
                    <textarea id="body_script_before" class="form-control" name="body_script_before">{!!$user->body_script_before!!}</textarea>
                </div>
                <div class="mb-3">
                    <label for="body_script_after" class="form-label fw-bold">{{ __('Scrip body after') }}</label>
                    <textarea id="body_script_after" class="form-control" name="body_script_after">{!!$user->body_script_after!!}</textarea>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script src="{{ asset('static/js/select2.min.js') }}"></script>
    <script src="{{ asset('static/js/tinymce.plugins.js') }}"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route('admin.user.upload') }}');
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
                images_upload_url: '{{ route('admin.user.upload') }}',
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
                images_upload_handler: example_image_upload_handler,
                readonly: {{ Auth::user()->can('UserController.edit') ? 'false' : 'true' }}
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

        async function uploadImage(event, name) {
            const file = $(event)[0].files;
            const base64 = await convertBase64(file[0]);
            document.getElementById(`${name.id}_thumbnail`).src = base64;
        }
    </script>
@endsection
