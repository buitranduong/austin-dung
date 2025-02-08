@extends('layouts.theme')

@section('content')
    <section class="success-order">
        <img src="{{ asset('static/theme/images/success-bn.png') }}" alt="" title="">
        <h2 class="title"><i class="ic ic-success"></i> Đặt sim thành công</h2>
    </section>
    <section class="success-detail">
        <div class="success-note"> Cảm ơn quý khách đã cho SimThangLong.vn cơ hội phục vụ. <br>{{ $seller_message }}</div>
        <section class="success-bill">
            <h3 class="sub-title">Thông tin đơn hàng</h3>
{{--            <div>Mã đơn hàng: <strong id="textToCopy">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::limit($sim_order->id, 8, '')) }}</strong>--}}
{{--                <span id="copyButton"><i class="icon-copy"></i>Sao chép</span>--}}
{{--            </div>--}}
            <div>Số thuê bao: <strong id="textToCopy" class="green">{{ $sim_order->sim }}</strong><span id="copyButton"><i class="icon-copy"></i>Sao chép</span></div>
            <p>Giá bán: <strong class="red">{{ format_money($sim_order->amount) }}<br></strong></p>
            @if($sim_order->order_type == \App\Enums\OrderType::INSTALLMENT)
            <p>Trả trước: <strong>{{ format_money($sim_order->attributes['so_tien_tra_truoc']) }}</strong>&nbsp;<span class="red">({{ $sim_order->attributes['tra_truoc'] }}%)</span></p>
            <p>Kỳ hạn: <strong>{{ $sim_order->attributes['ky_han'] }} tháng</strong></p>
            @endif
            <p><strong>Nhận hàng tại nhà/ tại cửa hàng</strong></p>
            <div class="line"></div>
            <p>Khách hàng: {{ $sim_order->name }}</p>
            <p>Điện thoại liên hệ: {{ $sim_order->phone }}</p>
            <p>Địa chỉ giao sim: {{ $sim_order->address }}</p>
        </section>
        <div class="success-ct">
            <p><strong>Thủ tục đăng ký chính chủ sim:</strong></p>
            <p>1, Ảnh Chứng minh thư (hoặc Căn cước công dân hoặc Hộ chiếu) của chủ thuê bao.</p>
            <p>2, Ảnh chân dung chủ thuê bao tại thời điểm giao dịch.</p>
            <p><i>Quý khách vui lòng chuẩn bị trước để cung cấp cho nhân viên giao dịch khi mua sim.</i></p>
        </div>
        <div class="success-contact"> Khi cần hỗ trợ vui lòng gọi <a class="smooth" href="tel:{{ str_replace(['.',','], '', $hotlineSetting->seller) }}" title=""
                                                                     rel="nofollow,noindex">{{ $hotlineSetting->seller }}</a> (7:30-22:00) </div> <a href="/" class="post-more">Mua
            thêm sim khác</a>
        <div class="break-5"></div>
    </section>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            const path = window.location.pathname;
            if(typeof dataLayer !== 'undefined'){
                if (path === "/hoan-tat-dat-sim.html") {
                    dataLayer.push({
                        'event': 'hoanTatDatSim',
                        'phoneEC': '{{ $sim_order->phone }}',
                        'purTotal': Number({{ $sim_order->amount }}),
                        'purId': '{{ $sim_order->sim }}'
                    });
                } else if (path === "/hoan-tat-dat-sim-theo-yeu-cau.html") {
                    dataLayer.push({
                        'event': 'hoanTatDatSimTheoYeuCau',
                        'phoneEC': '{{ $sim_order->phone }}',
                        'purTotal': Number({{ $sim_order->amount }}),
                        'purId': '{{ $sim_order->sim }}'
                    });
                }
            }
        });
    </script>
@endsection
