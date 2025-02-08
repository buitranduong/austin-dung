@extends('layouts.blog')

@section('content')
    <main id="contents">
        <div class="container post-page">
            <section class="post-main">
                <div class="list-grid-post grid-post-by-category">
                    <div class="header-page author">
                        <div class="archive-description">
                            <div class="description">
                                <h1 class="title-post">{{ __('Kết quả tìm kiếm') }}</h1>
                                <div>
                                    {{ request()->get('q') }}
                                </div>
                            </div>
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
