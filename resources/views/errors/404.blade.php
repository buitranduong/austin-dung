<!doctype html>
<html class="{{ $htmlClass }}" lang="vi" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
    <base href="{{ url('') }}/" />
    {!! Meta::placement('head_script_before')->toHtml() !!}
    {!! Meta::toHtml() !!}
    {!! Meta::placement('head_script_after')->toHtml() !!}
</head>
<body @if($homepage) id="homepage" @endif class="{{ $phone ? 'mobile' : 'pc' }}">
{!! Meta::placement('body_script_before')->toHtml() !!}
@if($phone)
    @include('components.theme.header.mobile')
@else
    @include('components.theme.header.desktop')
@endif
<main id="contents" class="container">
    <x-theme.aside.left :mobile="$phone" />
    <div class="content" role="main">
        @if(!isset($hidden_form_search))
            @include('components.theme.section.form-search')
        @endif
        <section class="list-sim-desc">
            <h1>SIM số đẹp</h1>
            <div class="text-desc view_pc">
                <strong>Sim so dep</strong> giá rẻ các mạng Viettel, Mobi, Vina. Bán Sim số đẹp giá gốc,
                đăng ký thông tin chính chủ. Giao <i>sim số đẹp</i> miễn phí Toàn Quốc
            </div>
            <p class="mt-20 text-center">{{ $exception->getMessage() ?: 'Đường dẫn bạn truy cập không tồn tại !' }}</p>
            <div class="text-center link-back-page view_pc mt-20">
                <strong>&lt;&lt; <a href="{{ url('/') }}">Về trang chủ</a></strong>
            </div>
        </section>
    </div>
    <x-theme.aside.right :$hotlineSetting :$blogPostLatest/>
</main>
@includeWhen($phone, 'components.theme.block.footer-filter-mobile')
<x-theme.footer.footer :$hotlineSetting :$mobile/>
{!! Meta::placement('body_script_after')->toHtml() !!}
</body>
</html>
