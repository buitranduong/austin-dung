<section class="form-search view_pc">
    <form name="search" method="GET" action="/tim-kiem" onSubmit="return handleSearchSubmit(event)">
        <div class="d-flex form-search-inner">
            <input title="Search" required id="search-input" class="search-input" name="q" type="tel"
                   autocomplete="off" placeholder="Nhập số cần tìm" value="{{ $keyword ?? '' }}" oninput="handleSearchChange(event)">
            <button class="search-btn" type="submit">
                <svg width="15px" height="15px">
                    <path
                        d="M11.618 9.897l4.224 4.212c.092.09.1.23.02.312l-1.464 1.46c-.08.08-.222.072-.314-.02L9.868 11.66M6.486 10.9c-2.42 0-4.38-1.955-4.38-4.367 0-2.413 1.96-4.37 4.38-4.37s4.38 1.957 4.38 4.37c0 2.412-1.96 4.368-4.38 4.368m0-10.834C2.904.066 0 2.96 0 6.533 0 10.105 2.904 13 6.486 13s6.487-2.895 6.487-6.467c0-3.572-2.905-6.467-6.487-6.467 ">
                    </path>
                </svg> Tìm kiếm
            </button>
        </div>
    </form>
    <ul class="search-syntax">
        <li>
            <label for="search-input">
                Tìm sim có số <strong>6789</strong> bạn hãy gõ <strong>6789</strong>
            </label>
        </li>
        <li>
            Tìm sim có đầu <strong>090 </strong>đuôi <strong>8888</strong> hãy gõ
            <strong>090*8888</strong>
        </li>
        <li>
            Tìm sim bắt đầu bằng <strong>0914</strong> đuôi bất kỳ, hãy
            gõ:&nbsp;<strong>0914*</strong>
        </li>
    </ul>
</section>
{{--@if(!$mobile || ($mobile && $homepage))--}}
{{--    <section class="homepage-banner d-flex">--}}
{{--        <a href="/sim-dep-tra-gop" title="SIM số đẹp trả góp">--}}
{{--            <img src="{{ asset('static/theme/images/sim_tra_gop.webp') }}" alt="simthanglong" width="191"--}}
{{--                 height="113">--}}
{{--        </a>--}}
{{--        <a href="/thu-mua-sim-so-dep" title="Thu mua SIM số đẹp">--}}
{{--            <img src="{{ asset('static/theme/images/cam_sim_so_dep.webp') }}" alt="simthanglong" width="191"--}}
{{--                 height="113">--}}
{{--        </a>--}}
{{--        <a href="/thu-mua-sim-so-dep" title="Thu mua SIM số đẹp">--}}
{{--            <img src="{{ asset('static/theme/images/thu_mua_sim.webp') }}" alt="simthanglong" width="191"--}}
{{--                 height="113">--}}
{{--        </a>--}}
{{--    </section>--}}
{{--@endif--}}
