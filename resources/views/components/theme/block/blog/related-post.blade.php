@props([
    'related_posts'=>''
])
@if($related_posts)
    <div class="list-grid-post">
        <h2 class="title-post">{{ __('RELATED POSTS') }}</h2>
        <div class="list-grid-post-inner">
            @foreach($related_posts as $post)
                <x-theme.block.blog.grid-post-item :$post/>
            @endforeach
        </div>
    </div>
@endif
