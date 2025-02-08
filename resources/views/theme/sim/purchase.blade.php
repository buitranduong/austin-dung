@extends('layouts.theme')

@section('content')
    @if($success)
        <section class="thu-mua-sim-success">
            <img src="/static/theme/images/like.png" alt="" width="100" height="95">
            <h1>Gửi yêu cầu thành công!</h1>
            <p>Cảm ơn anh/chị đã cho Sim Thăng Long cơ hội được phục vụ<br>
                Chúng tôi sẽ liên lạc lại bằng điện thoại trong ít phút nữa.</p>
        </section>
        <div class="text-center link-back-page view_pc">
            <strong>&lt;&lt; <a href="/thu-mua-sim-so-dep">Về trang trước</a></strong>
        </div>
    @else
        <section class="thu-mua-sim">
            <h1>Thu mua - cho vay thế chấp sim số đẹp</h1>
            <div class="con-thu-mua">
                <h3>
                    <span class="clr-red">Thu mua sim</span> và
                    <span class="clr-red">cho vay thế chấp bằng sim</span>(hay còn gọi là “cầm cố sim”) là dịch vụ
                    chuyên nghiệp của simthanglong.vn dành cho khách hàng
                    đang sử dụng sim
                    số đẹp.
                </h3>
                <p class="text-center clr-blue text-call">✆ Gọi ngay
                    <a href="tel:0901686699"><span class="clr-red">0901.68.6699</span></a>
                    để được tư vấn chi tiết!
                </p>
                <h3 class="sub-title1">LỢI ÍCH KHI GIAO DỊCH TẠI SIM THĂNG LONG</h3>
                <p>Phương châm của chúng tôi là mang lại lợi ích tốt nhất cho khách hàng: </p>
                <ul class="list-item-price">
                    <li>
                        <img alt="" src="/static/theme/images/muiten.gif" height="9" width="26">Định
                        giá sim <strong>CAO NHẤT</strong>
                    </li>
                    <li>
                        <img alt="" src="/static/theme/images/muiten.gif" height="9" width="26">Lãi suất
                        <strong>THẤP NHẤT</strong>
                    </li>
                    <li>
                        <img alt="" src="/static/theme/images/muiten.gif" height="9" width="26">Thủ tục
                        <strong>NHANH CHÓNG</strong>
                    </li>
                    <li>
                        <img alt="" src="/static/theme/images/muiten.gif" height="9" width="26">Giải ngân
                        <strong>NGAY</strong>
                    </li>
                    <li>
                        <img alt="" src="/static/theme/images/muiten.gif" height="9" width="26">Đa dạng các
                        loại sim thu mua và cho vay
                    </li>
                    <li>
                        <img alt="" src="/static/theme/images/muiten.gif" height="9" width="26">Thông tin
                        khách hàng được giữ bí mật tuyệt đối
                    </li>
                </ul>

                @include('components.theme.section.form-purchase')

                <h3 class="sub-title1">CÁC LOẠI SIM THU MUA VÀ CHO VAY THẾ CHẤP</h3>
                <p>Hiện tại <strong>Sim Thăng Long</strong> thu mua và cho vay thế chấp các dạng sim số đẹp sau:</p>
                <ul class="list-item-price">
                    <li>
                        <img alt="" src="/static/theme/images/muiten2.png" height="9" width="20">Sim được
                        chúng tôi định giá <strong> trên 5 triệu</strong>
                    </li>
                    <li>
                        <img alt="" src="/static/theme/images/muiten2.png" height="9" width="20">
                        <strong>Sim 10 số </strong> thuộc mạng Viettel, Mobifone, Vinaphone
                    </li>
                    <li>
                        <img alt="" src="/static/theme/images/muiten2.png" height="9" width="20">Các dạng
                        sim số đẹp ưu tiên thu mua và cho vay thế chấp:
                        <strong>Sim lục quý</strong> các loại, <strong>Sim ngũ quý</strong> các loại, <strong>sim tứ
                            quý</strong> các loại, <strong>sim tam hoa</strong>
                        666 – 888 – 999, <strong>sim taxi</strong>, <strong>sim thần tài</strong>, <strong>sim lộc
                            phát</strong>, sim năm sinh full, sim kép, sim số tiến.
                    </li>
                </ul>
                <h3 class="sub-title1">ĐIỀU KIỆN THU MUA VÀ CHO VAY THẾ CHẤP</h3>
                <p>Điều kiện của <strong>Sim Thăng Long</strong> rất đơn giản, chỉ cần:</p>
                <ul class="list-item-price">
                    <li>
                        <img alt="" src="/static/theme/images/muiten2.png" height="9" width="20">Sim đứng
                        chính chủ Có chứng minh thư gốc, hoặc hộ chiếu
                    </li>
                    <li>
                        <img alt="" src="/static/theme/images/muiten2.png" height="9" width="20">Nếu sim
                        không đứng chính chủ, quý khách phải nhờ chính chủ làm thủ tục
                    </li>
                    <li>
                        <img alt="" src="/static/theme/images/muiten2.png" height="9" width="20">Nếu là công
                        ty thì phải có dấu đỏ, giấy giới thiệu, hoặc giám đốc đi làm thủ tục
                    </li>
                    <li>
                        <img alt="" src="/static/theme/images/muiten2.png" height="9" width="20">Không nhận
                        mua lại những sim cam kết trả sau, sim không sang tên được
                    </li>
                </ul>
                <p>Với phương châm <strong class="clr-blue">“hài lòng khách bán, vừa lòng khách mua”</strong>, đến
                    với chúng tôi bạn dù với dịch vụ
                    nào Quý khách cũng sẽ được phục vụ tốt nhất.</p>
                <p class="text-center clr-blue text-call">✆ Gọi ngay
                    <a href="tel:0901686699"><span class="clr-red">0901.68.6699</span></a>
                    để được tư vấn chi tiết!
                </p>
            </div>
        </section>
    @endif
@endsection
