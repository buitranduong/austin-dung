@extends('layouts.blog')

@section('content')
    <main id="contents">
        <div class="container post-page">
            <section class="post-main">
                <div class="header-page">
                    <h1 class="entry-title">
                        {{ $post->title }}
                    </h1>
                    <div class="entry-content">{!! $post->content !!}</div>
                </div>
            </section>
        </div>
    </main>
@endsection
