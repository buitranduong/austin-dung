@props([
    'category'=>''
])
@if(!empty($category))
    <div class="list-grid-post">
        <h2 class="title-post">{{ $category->name }}</h2>
        <a class="btn-view-all" href="{{ blog_route('blog.category',[$category->slug]) }}"><span>{{ __('Xem thêm') }}</span></a>
        <div class="list-grid-post-inner">
            @if(!empty($category->posts))
                @foreach($category->posts as $post)
                    <x-theme.block.blog.grid-post-item :$post/>
                @endforeach
            @endif
        </div>
    </div>
@endif
