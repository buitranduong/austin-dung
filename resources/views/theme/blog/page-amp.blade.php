@extends('layouts.amp')

@section('content')
    <main id="content" role="main" class="">
        <article class="recipe-article">
            <header>
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
        </article>
    </main>
@endsection
