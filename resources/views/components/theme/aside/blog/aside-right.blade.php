<aside class="post-aside">
    <section class="block-post-cat">
        <form name="search" method="GET" action="{{ blog_route('blog.search') }}">
            <div class="d-flex form-search-inner">
                <input title="Nhập nội dung cần tìm" required class="blog-search-input" name="q" type="text" placeholder="Nhập nội dung cần tìm"/>
                <button class="blog-search-btn" type="submit">
                    <svg width="15px" height="15px">
                        <path d="M11.618 9.897l4.224 4.212c.092.09.1.23.02.312l-1.464 1.46c-.08.08-.222.072-.314-.02L9.868 11.66M6.486 10.9c-2.42 0-4.38-1.955-4.38-4.367 0-2.413 1.96-4.37 4.38-4.37s4.38 1.957 4.38 4.37c0 2.412-1.96 4.368-4.38 4.368m0-10.834C2.904.066 0 2.96 0 6.533 0 10.105 2.904 13 6.486 13s6.487-2.895 6.487-6.467c0-3.572-2.905-6.467-6.487-6.467 ">
                        </path>
                    </svg>
                </button>
            </div>
        </form>
    </section>
    <section class="block-post-cat">
        <h2 class="title-post">{{ __('Chủ đề') }}</h2>
        <ul class="list-post-category">
            @foreach($categories as $category)
            <li><a href="{{ blog_route('blog.category',[$category->slug]) }}" title="">{{ $category->name }}</a></li>
            @endforeach
        </ul>
    </section>
    <section class="block-post-cat">
        <h2 class="title-post">{{ __('Từ khóa') }}</h2>
        <div class="list-tags">
            @foreach($tags as $tag)
                <a href="{{ blog_route('blog.tag',[$tag->slug]) }}" class="tags-name">{{ $tag->name }} ({{ $tag->posts_count }})</a>
            @endforeach
        </div>
    </section>
</aside>
