@props([
    'before'=>'',
    'after'=>'',
])
{!! $errors->first() !!}
<form action="{{ route('admin.tag.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    {!! $before !!}
    <div>
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">{{ __('Tên thẻ') }}</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                   aria-describedby="nameHelp" required>
            <div id="nameHelp" class="form-text fst-italic text-danger-emphasis">Lưu ý: {{ __('Tên thẻ') }} không được dài
                quá 255 ký tự
            </div>
            @if ($errors->has('name'))
                <span class="error-message text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" name="featured" value="1" type="checkbox" role="switch" id="flexSwitchCheckDefault" aria-describedby="featuredHelp" @cannot('TagController.edit') disabled @endif>
                <label class="form-check-label fw-bold" for="flexSwitchCheckDefault">{{ __('Hiển thị ngoài trang') }}</label>
            </div>
            <div id="featuredHelp" class="form-text fst-italic text-danger-emphasis">Lưu ý: Bật để xuất hiện ở danh mục từ khóa ngoài trang</div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label fw-bold">{{ __('Giới thiệu') }}</label>
            <textarea id="description" name="description" class="form-control mini-editor"></textarea>
        </div>
        <div class="card mt-3">
            <div class="card-header fw-bold">
                {{ __('Ảnh đại diện') }}
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="input-group custom-file-button">
                        <label class="input-group-text" for="featured_image_tags">{{ __('Chọn ảnh') }}</label>
                        <input onchange="uploadImage(this,'thumb_tags')" name="featured_image" accept=".jpg,.jpeg,.png,.webp,.gif" class="form-control"
                               type="file" id="featured_image_tags">
                        <div class="input-group-text">
                            <img src="" id="featured_image_thumb_tags" width="100%" height="auto" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3"><x-admin.seo-meta/></div>
    </div>
    {!! $after !!}
</form>
