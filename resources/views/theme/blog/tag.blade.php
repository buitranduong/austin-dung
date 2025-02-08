@extends('layouts.blog')

@section('content')
    <main id="contents">
        <div class="container post-page">
            <section class="post-main">
                <div class="list-grid-post grid-post-by-category">
                    <div class="header-page">
                        <h1 class="title-post">{{ __('TAG') }}: {{ $tag->name }}</h1>
                        <div class="archive-description">
                            {!! $tag->description !!}
                        </div>
                    </div>
                    @if($posts)
                        <div class="list-grid-post-inner">
                            @foreach($posts as $post)
                                <x-theme.block.blog.grid-post-item className="post-entry-summary" :$post/>
                            @endforeach
                        </div>
                        {!! $posts->onEachSide(1)->links('components.theme.block.blog.pagination') !!}
                    @endif
                </div>
            </section>
            @include('components.theme.aside.blog.aside-right')
        </div>
    </main>
@endsection
