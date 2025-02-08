<!doctype html>
<html class="{{ $htmlClass }}" lang="vi" prefix="og: http://ogp.me/ns#" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" ontouchmove>
<head>
    {!! Meta::placement('head_script_before')->toHtml() !!}
    {!! Meta::toHtml() !!}
    {!! Meta::placement('head_script_after')->toHtml() !!}
</head>
<body class="{{ $phone ? 'mobile' : 'pc' }}" tabindex="0">
{!! Meta::placement('body_script_before')->toHtml() !!}
@include('components.theme.header.mobile')
@include('components.theme.header.desktop')
@yield('content')
<x-theme.footer.footer :$hotlineSetting :$mobile/>
{!! Meta::placement('body_script_after')->toHtml() !!}
</body>
</html>
