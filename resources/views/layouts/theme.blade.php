<!doctype html>
<html class="{{ $htmlClass }}" lang="vi" prefix="og: http://ogp.me/ns#" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" ontouchmove>
<head>
    {!! $generalSetting->head_script_before !!}
    {!! Meta::placement('head_script_before')->toHtml() !!}
    {!! Meta::toHtml() !!}
    {!! $generalSetting->head_script_after !!}
    {!! Meta::placement('head_script_after')->toHtml() !!}
</head>
<body id="{{ $homepage ? 'homepage' : 'category' }}" class="{{ $phone ? 'mobile' : 'pc' }}" tabindex="0">
{!! $generalSetting->body_script_before !!}
{!! Meta::placement('body_script_before')->toHtml() !!}
@include('components.theme.header.mobile')
@include('components.theme.header.desktop')
<main id="contents" class="container">
    <x-theme.aside.left :mobile="$phone" />
    <div class="content" role="main">
        @if(!isset($hidden_form_search))
            @include('components.theme.section.form-search')
        @endif
        @yield('content')
    </div>
    <x-theme.aside.right :$hotlineSetting :$blogPostLatest :$simOrderLatest/>
</main>
    @includeWhen($phone, 'components.theme.block.footer-filter-mobile')
<x-theme.footer.footer :$hotlineSetting :$mobile/>
{!! $generalSetting->body_script_after !!}
{!! Meta::placement('body_script_after')->toHtml() !!}
</body>
</html>
