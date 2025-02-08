@extends('layouts.admin')
@section('preload')
    <x-admin.offcanvas title="{{ __('Seo Meta') }}" scroll="true" backdrop="false" id="offcanvasSeo">
        <x-admin.seo-meta :meta_data="$meta_data" :related_content='$tag->related_content' :head_script_before="$tag->head_script_before" :head_script_after="$tag->head_script_after" :body_script_before="$tag->body_script_before" :body_script_after="$tag->body_script_after" action="{{ route('admin.tag.seo-meta',[$tag->id]) }}">
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
@endsection
@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.tag.update', [$tag]) }}" method="POST" autocomplete="off"
            enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="d-flex mb-3 pb-3 border-bottom">
                <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                    <a href="{{ route('admin.tag.index') }}" class="btn btn-secondary">{{ __('Hủy') }}</a>
                    @can('TagController.edit')
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                        </svg>
                        {{ __('Lưu') }}
                    </button>
                    @endif
                </div>
                <div>
                    @can('TagController.seoMeta')
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
            <div>
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">{{ __('Tên thẻ') }}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $tag->name }}"
                        aria-describedby="nameHelp" required @cannot('TagController.edit') disabled @endif>
                    <div id="nameHelp" class="form-text fst-italic text-danger-emphasis">Lưu ý: {{ __('Tên danh mục') }}
                        không được dài
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
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ $tag->slug }}"
                        aria-describedby="slugHelp" required @cannot('TagController.edit') disabled @endif>
                    <div id="nameHelp" class="form-text fst-italic text-danger-emphasis">Lưu ý: {{ __('Slug') }} không
                        được dài
                        quá 255 ký tự và không trùng với {{ __('slug') }} đã có
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input @if($tag->featured) checked @endif class="form-check-input" name="featured" value="1" type="checkbox" role="switch" id="flexSwitchCheckDefault" aria-describedby="featuredHelp" @cannot('TagController.edit') disabled @endif>
                        <label class="form-check-label fw-bold" for="flexSwitchCheckDefault">{{ __('Hiển thị ngoài trang') }}</label>
                    </div>
                    <div id="featuredHelp" class="form-text fst-italic text-danger-emphasis">Lưu ý: Bật để xuất hiện ở danh mục từ khóa ngoài trang</div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">{{ __('Mô tả') }}</label>
                    <textarea class="form-control mini-editor" name="description">{{ $tag->description }}</textarea>
                </div>
                <div class="card mt-3">
                    <div class="card-header fw-bold">
                        {{ __('Ảnh đại diện') }}
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="input-group custom-file-button">
                                <label class="input-group-text" for="featured_image">{{ __('Chọn ảnh') }}</label>
                                <input name="featured_image" accept=".jpg,.jpeg,.png,.webp,.gif" class="form-control"
                                    type="file" id="featured_image" @cannot('TagController.edit') disabled @endif>
                                <div class="input-group-text">
                                    <img id="featured_image_thumbnail" width="30%" height="auto"
                                        src="{{ url("storage/{$tag->featured_image}") }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
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
                statusbar: false,
                readonly: {{ Auth::user()->can('TagController.edit') ? 'false' : 'true' }}
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
