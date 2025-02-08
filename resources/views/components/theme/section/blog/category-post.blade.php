@props([
    'category'=>''
])
@if(!empty($category))
    <h2 class="title-post">{{ $category->name }}</h2>
    <a class="btn-view-all" href="{{ blog_route('blog.category',[$category->slug]) }}"><span>{{ __('Xem thêm') }}</span></a>
    @php
        $posts = $category->posts;
        $feature_post = $posts->first();
        $posts->shift();
    @endphp
    <x-theme.block.blog.post-item className="blogs-large" :post="$feature_post"/>
    <div class="list-post">
        @foreach($posts as $post)
            <x-theme.block.blog.post-item className="blogs-normal-item" :$post/>
        @endforeach
    </div>
@endif
