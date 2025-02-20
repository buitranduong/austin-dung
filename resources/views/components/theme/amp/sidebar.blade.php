<amp-sidebar
    id="header-sidebar"
    class="ampstart-sidebar px3"
    layout="nodisplay"
>
    <div class="flex justify-start items-center ampstart-sidebar-header">
        <div
            role="button"
            aria-label="close sidebar"
            on="tap:header-sidebar.toggle"
            tabindex="0"
            class="ampstart-navbar-trigger items-start"
        >
            ✕
        </div>
    </div>
    <nav class="ampstart-sidebar-nav ampstart-nav">
        <ul class="list-reset m0 p0 ampstart-label">
            <li class="ampstart-nav-item">
                <a class="ampstart-nav-link" href="{{ url('/') }}">TRANG CHỦ</a>
            </li>
            <li class="ampstart-nav-item">
                <a class="ampstart-nav-link" href="{{ blog_route('blog.author',['slug'=>'austindung']) }}">GIỚI THIỆU</a>
            </li>
            <li class="ampstart-nav-item">
                <a class="ampstart-nav-link" href="{{ blog_route('blog.category',['slug'=>'tin-nguong']) }}">TÍN NGƯỠNG</a>
            </li>
            <li class="ampstart-nav-item">
                <a class="ampstart-nav-link" href="{{ blog_route('blog.category',['slug'=>'cung-hoang-dao']) }}">CUNG HOÀNG ĐẠO</a>
            </li>
            <li class="ampstart-nav-item">
                <a class="ampstart-nav-link" href="{{ blog_route('blog.post',['slug'=>'lien-he']) }}">LIÊN HỆ</a>
            </li>
        </ul>
    </nav>
</amp-sidebar>
