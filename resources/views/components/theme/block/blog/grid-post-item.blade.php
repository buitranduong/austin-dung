@props([
    'post'=>'',
    'className'=>''
])
@if(!empty($post))
    <article class="blogs-large">
        <div class="post-img">
            @if($post->featured_image)
                <a href="{{ blog_route('blog.post',[$post->slug]) }}" title="{{ $post->title }}" aria-label="{{ $post->title }}">
                    <img loading="lazy" decoding="async" src="{{ feature_image($post->featured_image, 293, 158) }}" alt="" class="lazy" width="293" height="181">
                </a>
            @endif
        </div>
        <div class="link-category"><a href="{{ blog_route('blog.category',[$post->category->slug]) }}">{{ $post->category->name }}</a></div>
        <h2 class="post-title">
            <a href="{{ blog_route('blog.post',[$post->slug]) }}" title="{{ $post->title }}" aria-label="{{ $post->title }}">
                {{ $post->title }}
            </a>
        </h2>
        <div class="post-meta">
            <time>{{ $post->published_at->isoFormat('D MMMM, YYYY') }}</time> - {{ __('by') }} <a href="{{ blog_route('blog.author',[$post->createdByUser->slug]) }}" title="{{ $post->createdByUser->name }}">{{ $post->createdByUser->name }}</a>
        </div>
        @if($className == 'post-entry-summary')
            <div class="post-entry-summary">{{ !empty($post->excerpt) ? $post->excerpt : \Illuminate\Support\Str::of($post->content)->words(30)->stripTags()->toHtmlString() }}</div>
            <div class="post-btn">
                <a href="{{ blog_route('blog.post',[$post->slug]) }}" class="th-read-more" aria-label="{{ __('Read More') }}: {{ $post->title }}">{{ __('Read More') }}</a>
            </div>
        @endif
    </article>
@endif
