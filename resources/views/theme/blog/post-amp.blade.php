@extends('layouts.amp')

@section('content')
    <main id="content" role="main" class="">
        <article class="recipe-article">
            <header>
                @if(!empty($post->category))
                    <a href="{{ blog_route('blog.category',[$post->category->slug]) }}" class="ampstart-subtitle block px1 pt2 link-category">{{ $post->category->name }}</a>
                @endif
                <h1 class="mb3 pt3 px1">{{ $post->title }}</h1>
                <!-- Start byline -->
                <address class="ampstart-byline clearfix mb4 px1 h5">
                    <time
                        class="ampstart-byline-pubdate block bold my1"
                        datetime="{{ $post->published_at->format('Y-m-d') }}"
                    >{{ \Illuminate\Support\Str::ucfirst($post->published_at->isoFormat('dddd D MMMM, YYYY')) }}</time>
                    <span>{{ __('author') }}:</span> <a rel="author" class="author" href="{{ blog_route('blog.author',[$post->createdByUser->slug]) }}">{{ $post->createdByUser->name }}</a>
                </address>
                <!-- End byline -->
            </header>
            <section class="px1 mb4">
                {!! $post->content !!}
            </section>
            @if($related_posts)
            <section class="px3 mb4">
                <div class="list-grid-post">
                    <h2 class="title-post">{{ __('RELATED POSTS') }}</h2>
                    <div class="list-grid-post-inner">
                        @foreach($related_posts as $post)
                            <article class="blogs-large mb4">
                                <div class="post-img">
                                    @if($post->featured_image)
                                        <a href="{{ blog_route('blog.post',[$post->slug]) }}" title="{{ $post->title }}" aria-label="{{ $post->title }}">
                                            <amp-img
                                                src="{{ feature_image($post->featured_image, 293, 158) }}"
                                                width="293"
                                                height="181"
                                                layout="responsive"
                                                alt="{{ $post->title }}"
                                            ></amp-img>
                                        </a>
                                    @endif
                                </div>
                                <h3 class="post-title mt1 mb1">
                                    <a href="{{ blog_route('blog.post',[$post->slug]) }}" title="{{ $post->title }}" aria-label="{{ $post->title }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <div class="post-meta">
                                    <time datetime="{{ $post->published_at->format('Y-m-d') }}">{{ $post->published_at->isoFormat('D MMMM, YYYY') }}</time> - {{ __('by') }} <a href="{{ blog_route('blog.author',[$post->createdByUser->slug]) }}" title="{{ $post->createdByUser->name }}">{{ $post->createdByUser->name }}</a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif
        </article>
    </main>
@endsection
