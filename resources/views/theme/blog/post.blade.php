@extends('layouts.blog')

@section('content')
    <main id="contents">
        <div class="container post-page">
            <section class="post-main">
                <div class="header-page">
                    @if(!empty($post->category))
                        <div class="link-category">
                            <a href="{{ blog_route('blog.category',[$post->category->slug]) }}" title="{{ $post->category->name }}">{{ $post->category->name }}</a>
                            <a style="display: none" target="_blank" href="https://news.google.com/publications/CAAqBwgKMMXGoAsw0tC4Aw/sections/CAQqEAgAKgcICjDFxqALMNLQuAMwr575Cw?hl=vi&gl=VN&ceid=VN%3Avi" title="Theo dõi STL trên google news">
                                <span class="text-google-news view_pc">Theo dõi STL trên - </span>
                                <img class="icon-google-news" src="/static/theme/images/ggnewslogo.svg" alt="Theo dõi STL trên Google news">
                            </a>
                        </div>
                    @endif
                    <h1 class="entry-title">
                        {{ $post->title }}
                    </h1>
                    @if($post->type != \App\Enums\PostType::Page)
                        <div class="entry-meta">
                            <span class="posted-on">
                                <time class="entry-date published" datetime="{{ $post->published_at->format('Y-m-d') }}">{{ \Illuminate\Support\Str::ucfirst($post->published_at->isoFormat('dddd D MMMM, YYYY')) }}</time>
                            </span>
                            <span class="meta-sep"> - </span>
                            <span class="byline"> {{ __('by') }} <span class="author vcard">
                                    <a class="url fn n" href="{{ blog_route('blog.author',[$post->createdByUser->slug]) }}">{{ $post->createdByUser->name }}</a>
                                </span>
                            </span>
                            <span class="meta-sep"> - </span>
                            <span class="comments-link">
                                {{ __('Leave a Comment') }}
                            </span>
                        </div>
                    @endif
                </div>
                <div id="toc-wrap" class="toc-wrap">
                    <div class="toc-title">NỘI DUNG CHÍNH</div>
                    <div id="toc"></div>
                </div>
                <div class="entry-content">
                    {!! $post->content !!}
                </div>
{{--                <x-theme.section.blog.table-sim-free title="SIM THĂNG LONG TẶNG SIM SỐ ĐẸP"/>--}}
                @if($post->tags->count())
                    <footer class="entry-footer">
                        <div class="post-tags-links">
                            <span class="post-tagged">{{ __('Tagged') }}</span>
                            @foreach($post->tags as $tag)
                                <a href="{{ blog_route('blog.tag',[$tag->slug]) }}" rel="tag">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    </footer>
                @endif
                <x-theme.block.blog.related-post :$related_posts/>
                <nav class="navigation post-navigation" aria-label="Bài viết">
                    <div class="nav-links">
                        <div class="nav-item">
                        @if(!empty($post->previous))
                            <a href="{{ blog_route('blog.post',[$post->previous->slug]) }}" rel="prev">
                                <span class="meta-nav" aria-hidden="true">{{ __('Previous Article') }}</span>
                                <span class="post-title">{{ $post->previous->title }}</span>
                            </a>
                        @endif
                        </div>
                        <div class="nav-item">
                        @if(!empty($post->next))
                            <a href="{{ blog_route('blog.post',[$post->next->slug]) }}" rel="next">
                                <span class="meta-nav" aria-hidden="true">{{ __('Next Article') }}</span>
                                <span class="post-title">{{ $post->next->title }}</span>
                            </a>
                        @endif
                        </div>
                    </div>
                </nav>
                @include('components.theme.block.blog.author-profile')
            </section>
            @include('components.theme.aside.blog.aside-right')
        </div>
    </main>
@endsection
