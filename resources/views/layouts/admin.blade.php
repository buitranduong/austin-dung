<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {!! Meta::toHtml() !!}
    <link href="{{ asset('static/css/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('static/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('static/css/app.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body>
    @yield('preload')
    <header class="border-bottom position-fixed w-100 top-0 z-1">
        @include('components.admin.nav')
    </header>
    <main id="app" class="d-flex flex-nowrap" style="margin-left: 280px; margin-top: 57px">
        <div class="small position-fixed start-0 z-1">
            @include('components.admin.sidebar')
        </div>
        <div class="flex-grow-1 p-3 bg-body-tertiary m-2 shadow rounded">
            @yield('content')
        </div>
    </main>
    <script src="{{ asset('static/js/jquery.min.js') }}"></script>
    <script src="{{ asset('static/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('static/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('static/js/app.js') }}"></script>
    @yield('script')
</body>
</html>
