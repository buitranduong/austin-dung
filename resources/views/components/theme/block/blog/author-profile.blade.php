<div class="post-author-box">
    @if(!empty($post->createdByUser->avatar))
    <div class="post-author-img">
        <img loading="lazy" decoding="async" alt="" src="{{ asset("storage/{$post->createdByUser->avatar}") }}" class="lazy" height="100"
             width="100" style="height: 100% !important;">
    </div>
    @endif
    <div class="post-author-content">
        <h4 class="author-name">{{ $post->createdByUser->name }}</h4>
        <div class="author-description">{{ $post->createdByUser->description }}</div>
        <div class="author">
            <a class="author-posts-link" href="{{ blog_route('blog.author',[$post->createdByUser->slug]) }}"
               title="{{ $post->createdByUser->name }}">{{ __('View all posts') }} {{ __('by') }} {{ $post->createdByUser->name }} → </a>
        </div>
    </div>
</div>
