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
        <form id="search-form" class="search" action="/tim-kiem" method="GET" onSubmit="return handleSearchSubmit(event)">
            <input title="Search" class="search-input" id="search-input" name="q" placeholder="Nhập số cần tìm" type="tel"
                   autocomplete="off" required oninput="handleSearchChange(event)" onblur="keyboardEnter(this)" value="{{ $keyword ?? '' }}">
            <button title="Search" id="search-submit" class="search-submit" type="submit">
                <span>Tìm</span>
                <i class="ic ic-search"></i>
            </button>
            <div class="search-helper">
                <p><label for="search-input">Tìm sim có số <strong>6789</strong> bạn hãy gõ
                        <strong>6789</strong></label></p>
                <p>Tìm sim có đầu <strong>090 </strong>đuôi <strong>8888</strong> hãy gõ <strong>090*8888</strong></p>
                <p>Tìm sim bắt đầu bằng <strong>0914</strong> đuôi bất kỳ, hãy gõ:&nbsp;<strong>0914*</strong></p>
            </div>
        </form>
    </div>
</header>
