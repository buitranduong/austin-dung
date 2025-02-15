@props([
    'post'=>'',
    'className'=>'blogs-large'
])
@if(!empty($post))
    <article class="{{ $className }}">
        <div class="post-img">
            @if($post->featured_image)
                <a href="{{ blog_route('blog.post',[$post->slug]) }}" title="{{ $post->title }}" aria-label="{{ $post->title }}">
                    @if($className == 'blogs-large')
                        <img loading="lazy" decoding="async" src="{{ feature_image($post->featured_image, 293, 158) }}" alt="" class="lazy" width="293" height="158">
                    @else
                        <img loading="lazy" decoding="async" src="{{ feature_image($post->featured_image, 101, 70) }}" alt="" class="lazy" width="101" height="70">
                    @endif
                </a>
            @endif
        </div>
        @if($className == 'blogs-large')
            <div class="link-category"><a href="{{ blog_route('blog.category',[$post->category->slug]) }}">{{ $post->category->name }}</a></div>
            <h3 class="post-title">
                <a href="{{ blog_route('blog.post',[$post->slug]) }}" title="{{ $post->title }}" aria-label="{{ $post->title }}">
                    {{ $post->title }}
                </a>
            </h3>
            <div class="post-meta">
                <time datetime="{{ $post->published_at->format('Y-m-d') }}">{{ $post->published_at->isoFormat('D MMMM, YYYY') }}</time> - {{ __('by') }} <a href="{{ blog_route('blog.author',[$post->createdByUser->slug]) }}" title="{{ $post->createdByUser->name }}">{{ $post->createdByUser->name }}</a>
            </div>
            <div class="post-entry-summary">{{ !empty($post->excerpt) ? $post->excerpt : \Illuminate\Support\Str::of($post->content)->words(30)->stripTags()->toHtmlString() }}</div>
        @else
            <div class="post-detail">
                <h3 class="post-title">
                    <a href="{{ blog_route('blog.post',[$post->slug]) }}" title="{{ $post->title }}" aria-label="{{ $post->title }}">
                        {{ $post->title }}
                    </a>
                </h3>
                <time datetime="{{ $post->published_at->format('Y-m-d') }}" class="meta">{{ $post->published_at->isoFormat('D MMMM, YYYY') }}</time>
            </div>
        @endif
    </article>
@endif
