@props([
    'name'=>'featured_image',
    'src'=>''
])
<div class="card mt-3">
    <div class="card-header fw-bold">
        {{ __('Ảnh đại diện') }}
    </div>
    <div class="card-body">
        <div class="mb-3">
            <div class="input-group custom-file-button">
                <label class="input-group-text" for="{{ $name }}">{{ __('Chọn ảnh') }}</label>
                <input name="{{ $name }}" accept=".jpg,.jpeg,.png,.webp,.gif" class="form-control"
                    type="file" id="{{ $name }}" onchange="uploadImage(this, {{$name}});">
            </div>
            <img id="{{ $name }}_thumbnail" width="100%" height="auto"
                 @if (!empty($src)) src="{{ url("storage/{$src}") }}" @endif
                 alt="">
        </div>
    </div>
</div>
