@props([
    'meta_data' => '',
    'head_script_before'=>'',
    'head_script_after'=>'',
    'body_script_before'=>'',
    'body_script_after'=>'',
    'related_content' => '',
    'action' => '',
    'before' => '',
    'after' => '',
])
@if(!empty($action))
<form accept-charset="utf-8" action="{{ $action }}" method="post">
    @csrf
@endif
    {!! $before !!}
    <div class="mb-3">
        <label for="seo-title" class="form-label fw-bold">{{ __('Tiêu đề SEO') }}</label>
        <input id="seo-title" type="text" class="form-control" name="meta_data[title]"
            value="{{ $meta_data['title'] ?? '' }}" autocomplete="off">
        <div class="form-text fst-italic text-danger-emphasis">Lưu ý: {{ __('Tiêu đề SEO') }} không được dài
            quá 255 ký tự
        </div>
        @error('meta_data[title]')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="seo-description" class="form-label fw-bold">{{ __('Mô tả SEO') }}</label>
        <textarea class="form-control" id="seo-description" name="meta_data[meta][description]" autocomplete="off">{{ $meta_data['meta']['description'] ?? '' }}</textarea>
        @error('meta_data[meta][description]')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="seo-keywords" class="form-label fw-bold">{{ __('Từ khóa SEO') }}</label>
        <input type="text" class="form-control" id="seo-keywords" name="meta_data[meta][keywords]"
            value="{{ $meta_data['meta']['keywords'] ?? '' }}" autocomplete="off">
        <div class="form-text fst-italic text-danger-emphasis">Lưu ý: {{ __('Từ khóa SEO') }} không được dài
            quá 255 ký tự
        </div>
        @error('meta_data[meta][keywords]')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="seo-keywords" class="form-label fw-bold">{{ __('Các trang liên quan') }}</label>
        <textarea class="form-control" name="related_content">{!! $related_content ? implode("&#13;&#10;", $related_content) : '' !!}</textarea>
        <div class="form-text fst-italic text-secondary-subtle">(Có thể nhập nhiều related pages, mỗi related pages cách
            nhau bởi một lần xuống dòng. Cú pháp: Tiêu đề|Link)
        </div>
    </div>
    <div class="mb-3">
        <label for="seo-keywords" class="form-label fw-bold">{{ __('Scrip head before') }}</label>
        <textarea class="form-control" name="head_script_before">{!! $head_script_before !!}</textarea>
    </div>
    <div class="mb-3">
        <label for="seo-keywords" class="form-label fw-bold">{{ __('Scrip head after') }}</label>
        <textarea class="form-control" name="head_script_after">{!!$head_script_after!!}</textarea>
    </div>
    <div class="mb-3">
        <label for="seo-keywords" class="form-label fw-bold">{{ __('Scrip body before') }}</label>
        <textarea class="form-control" name="body_script_before">{!!$body_script_before!!}</textarea>
    </div>
    <div class="mb-3">
        <label for="seo-keywords" class="form-label fw-bold">{{ __('Scrip body after') }}</label>
        <textarea class="form-control" name="body_script_after">{!!$body_script_after!!}</textarea>
    </div>
    {!! $after !!}
@if(!empty($action))
</form>
@endif
