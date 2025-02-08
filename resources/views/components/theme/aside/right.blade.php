@props([
    'hotlineSetting',
    'blogPostLatest',
    'simOrderLatest'
])
<aside class="sidebar-right view_pc">
    <x-theme.aside.sidebar.right title="Bán hàng Online" className="hotline-grid">
        <div class="hotline-inner hotline">
            <a href="tel:{{ str_replace(['.',','],'', $hotlineSetting->seller) }}" title="Call Sim Thăng Long" rel="nofollow, noindex">
                <img src="{{ asset('static/theme/images/phone0.png') }}" alt="Chat với Sim Thăng Long" class="lazy"
                     width="41" height="41">
                {{ $hotlineSetting->seller }}
            </a>
        </div>
        <div class="hotline-inner zalo">
            <a href="{{ $hotlineSetting->zalo }}" title="Sim Thăng Long Zalo" rel="nofollow, noindex">
                <img src="{{ asset('static/theme/images/zalo.webp') }}" loading="lazy" alt="Chat với Sim Thăng Long" class="lazy"
                     width="41" height="41">
                Chat tư vấn
            </a>
        </div>
        <h4 class="text-center">Góp ý, khiếu nại:<br>{{ $hotlineSetting->phone }}</h4>
    </x-theme.aside.sidebar.right>
    <x-theme.aside.sidebar.right title="Đơn hàng mới" className="list-order">
        @if(!empty($simOrderLatest))
        <ul>
            @foreach($simOrderLatest as $order)
                <li>
                    <h4>{{ skip_keyword_comment($order->name) }}</h4>
                    <div class="item-number">{{ Str::substrReplace($order->phone, '***', 5, 3) }}</div>
                    <div class="d-flex">
                        <span class="order-status {{ $order->order_type == \App\Enums\OrderType::INSTALLMENT ? 'order-buy' : 'order-success' }}">Đã đặt mua</span> ({{ $order->created_at->format('H\hi') }})
                    </div>
                </li>
            @endforeach
        </ul>
        @endif
    </x-theme.aside.sidebar.right>
    <x-theme.aside.sidebar.right title="Bạn cần biết" className="list-news">
        <ul>
            <li><a href="/bai-viet/cam-ket-ban-hang/" title="Cam kết bán hàng">Cam kết bán hàng</a></li>
            <li><a href="/bai-viet/kiem-tra-thong-tin-chu-thue-bao-di-dong-64/" title="Kiểm tra thông tin chủ thuê bao di động">Kiểm tra thông tin chủ thuê bao di động</a></li>
            <li><a href="/bai-viet/cach-mua-sim-va-thanh-toan-65/" title="Cách mua sim và thanh toán">Cách mua sim và thanh toán</a></li>
            <li><a href="/bai-viet/kiem-tra-sim-con-hay-da-ban-63/" title="Kiểm tra sim còn hay đã bán">Kiểm tra sim còn hay đã bán</a></li>
            <li><a href="/bai-viet/cach-chon-sim-hop-tuoi-27/" title="Cách chọn Sim hợp tuổi">Cách chọn Sim hợp tuổi</a></li>
            <li><a href="/bai-viet/tai-sao-mua-duoc-sim-gia-re-tai-sim-thang-long-66/" title="Tại sao mua được sim giá rẻ tại Sim Thăng Long">Tại sao mua được sim giá rẻ tại Sim Thăng Long</a></li>
            <li><a href="/bai-viet/nhung-dieu-can-biet-ve-chuyen-mang-giu-so-3036/" title="Những điều cần biết về chuyển mạng giữ số">Những điều cần biết về chuyển mạng giữ số</a></li>
        </ul>
    </x-theme.aside.sidebar.right>
    @if($blogPostLatest)
    <x-theme.aside.sidebar.right title="Tin mới cập nhật" className="list-news">
        <ul>
            @foreach($blogPostLatest as $post)
                <li><a href="{{ blog_route('blog.post',[$post->slug]) }}" title="{{ $post->title }}">{{ $post->title }}</a></li>
            @endforeach
        </ul>
    </x-theme.aside.sidebar.right>
    @endif
</aside>
