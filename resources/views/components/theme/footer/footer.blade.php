@props([
    'hotlineSetting'=> [],
    'mobile'=> null
])
<footer id="footer">
    <div class="container">
        @if(!$mobile)
            <nav class="footer-link view_pc-tab">
                <ul>
                    <li><a href="/bai-viet/gioi-thieu/" title="Giới thiệu Sim Thăng Long">Giới thiệu</a></li>
                    <li><a href="/bai-viet/cach-mua-sim-va-thanh-toan-65/" title="Mua hàng và thanh toán">Mua hàng & Thanh toán</a></li>
                    <li><a href="/bai-viet/" title="Kiến thức sim">Kiến thức sim</a></li>
                    <li><a href="/bai-viet/dieu-khoan-va-dieu-kien-giao-dich-tai-sim-thang-long-1900/" title="Điều khoản & điều kiện">Điều khoản & điều kiện</a></li>
                    <li><a href="/bai-viet/chinh-sach-doi-tra-3050/" title="Chính sách đổi trả">Chính sách đổi trả</a></li>
                    <li><a href="/bai-viet/chinh-sach-bao-mat-thong-tin-khach-hang-tai-sim-thang-long-1899/" title="Chính sách bảo mật">Chính sách bảo mật</a></li>
                    <li><a href="/bai-viet/lien-he/" title="Liên hệ">Liên hệ</a></li>
                    <li><a href="/sitemap.xml" title="Sitemap" target="_blank">Sitemap</a></li>
                </ul>
                <div class="text-center">
                    <a href="https://www.dmca.com/Protection/Status.aspx?ID=e68e1d2e-d810-441a-bf99-fd8a343d3eaf&refurl=https://simthanglong.vn/"
                       title="DMCA.com Protection Status" class="dmca-badge" id="dmca-badge">
                        <img width="100" height="20" src="https://images.dmca.com/Badges/dmca-badge-w100-5x1-02.png"
                             alt="DMCA.com Protection Status" class="lazy" loading="lazy" decoding="async"></a>
                </div>
            </nav>
        @endif
    </div>
</footer>
