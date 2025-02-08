<!doctype html>
<html class="{{ $htmlClass }}" lang="vi" prefix="og: http://ogp.me/ns#" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" ontouchmove>
<head>
    <base href="{{ url('') }}/" />
    {!! $generalSetting->head_script_before !!}
    {!! Meta::placement('head_script_before')->toHtml() !!}
    {!! Meta::toHtml() !!}
    {!! $generalSetting->head_script_after !!}
    {!! Meta::placement('head_script_after')->toHtml() !!}
</head>
<body id="category" class="{{ $phone ? 'mobile' : 'pc' }}" tabindex="0">
{!! $generalSetting->body_script_before !!}
{!! Meta::placement('body_script_before')->toHtml() !!}
@if($phone)
    @include('components.theme.header.mobile')
@else
    @include('components.theme.header.desktop')
@endif
<main id="contents" class="container page-phongthuy">
    <div class="wrap-phongthuy">
        @yield('content')
        @include('components.theme.aside.sidebar.right-phong-thuy')
    </div>
</main>
@includeWhen($phone, 'components.theme.block.footer-filter-mobile')
<x-theme.footer.footer :$hotlineSetting :$mobile/>
{!! $generalSetting->body_script_after !!}
{!! Meta::placement('body_script_after')->toHtml() !!}
</body>
</html>
