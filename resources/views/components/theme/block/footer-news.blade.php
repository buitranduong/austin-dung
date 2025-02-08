@props([
    'posts'=>'',
    'title'=>'',
    'link'=>''
])
@if($posts)
<div class="footer-news">
    <div class="container">
        <h2>{{ $title }}</h2>
        <ul class="list-news">
            @foreach($posts as $post)
            <li>
                <a href="{{ blog_route('blog.post',[$post->slug]) }}">
                    <div class="news-img">
                        @if(!empty($post->featured_image))
                        <img loading="lazy" decoding="async" src="{{ feature_image($post->featured_image, 190, 117) }}" alt="{{ $post->title }}" title="{{ $post->title }}" class="lazy" width="119" height="80">
                        @endif
                    </div>
                    <div class="news-content">
                        <h3>{{ $post->title }}</h3>
                        <div class="date">{{ $post->published_at->locale('vi')->diffForHumans() }}</div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
        <div class="text-center">
            <a href="{{ $link }}" class="btn-news-more">Xem thêm Tin bài khác <i class="ic-angle-arrow"></i></a>
        </div>
    </div>
</div>
@endif
