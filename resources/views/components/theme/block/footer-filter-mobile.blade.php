<div class="footer-inner-mobile view_sp">
    <nav class="filter-block">
        <x-theme.block.menu-mobile-popup/>
    </nav>
    @if(!$mobile || ($mobile && $homepage))
        <x-theme.block.footer-news title="Tin tức" link="{{ blog_route('blog.feature') }}" :posts="$blogPostLatest"/>
    @endif
{{--    @if($postRecruitment)--}}
{{--        <x-theme.block.footer-news title="Tuyển dụng" link="{{ blog_route('blog.category',['tuyen-dung']) }}" :posts="$postRecruitment"/>--}}
{{--    @endif--}}

    <div class="footer-about">
        <h2>Giới thiệu sim Thăng Long</h2>
        <div class="scroll-x about-images">
            <div class="img-item">
                <img src="{{ asset('static/theme/images/about01.webp') }}" loading="lazy" class="lazy" alt="Giới thiệu sim Thăng Long"
                     title="Giới thiệu sim Thăng Long" width="153" height="115">
            </div>
            <div class="img-item">
                <img src="{{ asset('static/theme/images/about02.webp') }}" loading="lazy" class="lazy" alt="Giới thiệu sim Thăng Long"
                     title="Giới thiệu sim Thăng Long" width="153" height="115">
            </div>
            <div class="img-item">
                <img src="{{ asset('static/theme/images/about03.webp') }}" loading="lazy" class="lazy" alt="Giới thiệu sim Thăng Long"
                     title="Giới thiệu sim Thăng Long" width="153" height="115">
            </div>
        </div>
    </div>
    <div class="footer-contact">
        <div class="container">
            <div class="policy">
                <div class="policy-item">
                    <i class="ic ic-card"></i> 100% Đăng ký <br class="view_ssm">chính chủ
                </div>
                <div class="policy-item">
                    <i class="ic ic-truck"></i> Miễn phí giao sim <br class="view_ssm">toàn quốc
                </div>
            </div>
            <div class="block-contact">
                <div class="contact-line">
                    <label>Gọi mua hàng</label>
                    <a href="tel:{{ str_replace(['.',','],'', $hotlineSetting->seller) }}" title="{{ $hotlineSetting->seller }}" rel="nofollow,noindex">
                        <i class="ic ic-call"></i> {{ $hotlineSetting->seller }}
                    </a>
                    <span>(7:30-22:00)</span>
                </div>
                <div class="contact-line">
                    <label>Chat tư vấn</label>
                    <a href="{{ $hotlineSetting->zalo }}" title="Chat tư vấn" rel="nofollow,noindex">
                        <i class="ic ic-zalo"></i>
                    </a>
                    <span>(7:30-22:00)</span>
                </div>
                <div class="contact-line">
                    <label>Gọi khiếu nại</label>
                    <a href="tel:{{ str_replace(['.',','],'', $hotlineSetting->phone) }}" title="{{ $hotlineSetting->phone }}" rel="nofollow,noindex">
                        <i class="ic ic-call"></i> {{ $hotlineSetting->phone }}
                    </a>
                    <span>(8:00-18:00)</span>
                </div>
            </div>
        </div>
    </div>
    <div class="contact-line pb-0 pt-0">
        <button class="arrow-btn toggle-btn active" data-target="#footer-menu-mobile" type="button">
            Các thông tin khác <i class="ic ic-arrow"></i>
        </button>
    </div>
    <div class="footer-menu" id="footer-menu-mobile">
        <div class="container">
            <ul>
                <li><a href="{{ blog_route('blog.post',['cach-mua-sim-va-thanh-toan-65']) }}" title="Hướng dẫn thanh toán" rel="nofollow">Hướng dẫn thanh toán</a></li>
                <li><a href="{{ blog_route('blog.post',['chinh-sach-bao-mat-thong-tin-khach-hang-tai-sim-thang-long-1899']) }}" title="Chính sách bảo mật">Chính sách bảo mật</a></li>
                <li><a href="{{ blog_route('blog.post',['chinh-sach-doi-tra-3050']) }}" title="Chính sách đổi trả, bảo hành">Chính sách đổi trả, bảo hành</a></li>
                <li><a href="{{ blog_route('blog.post',['gioi-thieu']) }}" title="Giới thiệu công ty">Giới thiệu công ty</a></li>
                <li><a href="{{ blog_route('blog.post',['lien-he']) }}" title="Liên hệ">Liên hệ</a></li>
                <li><a href="{{ asset('sitemap.xml') }}" title="Sitemap" target="_blank">Sitemap</a></li>
            </ul>
        </div>
    </div>
</div>
