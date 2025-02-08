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
                <a class="ampstart-nav-link" href="{{ url('/') }}">SIM SỐ ĐẸP</a>
            </li>
            <li class="ampstart-nav-item">
                <a class="ampstart-nav-link" href="{{ url('sim-phong-thuy') }}">SIM PHONG THỦY</a>
            </li>
            <li class="ampstart-nav-item">
                <a class="ampstart-nav-link" href="{{ url('sim-dep-tra-gop') }}">SIM TRẢ GÓP</a>
            </li>
            <li class="ampstart-nav-item">
                <a class="ampstart-nav-link" href="{{ url('dinh-gia-sim-ai') }}">ĐỊNH GIÁ SIM</a>
            </li>
            <li class="ampstart-nav-item">
                <a class="ampstart-nav-link" href="{{ url('thu-mua-sim-so-dep') }}">CẦM SIM - THU MUA SIM</a>
            </li>
            <li class="ampstart-nav-item">
                <a class="ampstart-nav-link" href="{{ blog_route('blog.post',['cach-mua-sim-va-thanh-toan-65']) }}">THANH TOÁN</a>
            </li>
            <li class="ampstart-nav-item">
                <a class="ampstart-nav-link" href="{{ blog_route('blog.feature') }}">TIN TỨC</a>
            </li>
        </ul>
    </nav>
</amp-sidebar>
