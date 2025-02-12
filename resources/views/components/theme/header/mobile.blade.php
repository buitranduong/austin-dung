<header id="header" class="header header_mobile view_tab-sp">
    <div class="container">
        <div class="header-top-bar">
            <a href="/" aria-label="Sim Thăng Long">
                @if($homepage)
                <img src="{{ asset('static/theme/images/sim-so-dep.svg') }}" alt="Sim Thăng Long" width="206" height="30">
                <i class="ic ic-home view_tab-sp"></i>
                @else
                <i class="ic ic-home"></i>
                @endif
            </a>
            <button class="header-menuBtn" type="button">
                <i class="ic ic-menu"></i><span class="text-menu"></span>
                <span class="close"><i class="ic ic-close2"></i><span>Đóng</span></span>
            </button>
        </div>
        <form id="search-form" class="search" action="/search" method="GET">
            <input title="Search" class="search-input" id="search-input" name="q" placeholder="Nhập nội dung cần tìm" type="text"
                   autocomplete="off" required onblur="keyboardEnter(this)" value="{{ request()->get('q') }}">
            <button title="Search" id="search-submit" class="search-submit" type="submit">
                <span>Tìm</span>
                <i class="ic ic-search"></i>
            </button>
        </form>
    </div>
</header>
