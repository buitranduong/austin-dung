@props([
    'sim_data'=>'',
    'phone'=>'',
    'mobile'=>false
])
<form id="formOrder" action="{{ route('order.store',[optional($sim_data['detail'])['id']]) }}" method="post">
    @csrf
    <input type="hidden" name="_g_key" id="_g_key">
    <section class="sim-detail">
        <h1>{{ optional($sim_data)['h1'] ?? optional($sim_data)['title'] }}</h1>
        <div class="con-box-border con-sim-detail">
            <div class="col-50">
                <div class="item-detail">
                    <label>Số sim:</label>
                    <div class="lbl-content-detail simso">{!! \Illuminate\Support\Str::of(optional($sim_data['detail'])['highlight'])->stripTags() !!}</div>
                </div>
                <div class="item-detail">
                    <label>Giá bán:</label>
                    <div class="lbl-content-detail sim-price" id="price-value">
                        @if(isset($sim_data['detail']['sell_price']))
                            {{ format_money($sim_data['detail']['sell_price']) }}
                            @if($sim_data['detail']['sell_price'] < $sim_data['detail']['pn'])
                                <span class="lbl-price-old">{!! optional($sim_data['detail'])['priceFormatted'] !!}</span>
                            @endif
                        @else
                            {!! optional($sim_data['detail'])['priceFormatted'] !!}
                        @endif
                    </div>
                </div>
                <div class="item-detail">
                    <label>Mạng:</label>
                    <div class="lbl-content-detail">
                        <a href="{{ isset(get_sim_tel($sim_data['detail']['telcoText'])['link']) ? get_sim_tel($sim_data['detail']['telcoText'])['link'] : '' }}" title="Sim số đẹp {{ Str::ucfirst(optional($sim_data['detail'])['telcoText']) }}">
                            <i class="ic ic-{{ optional($sim_data['detail'])['telcoText'] }}"></i>
                        </a>
                    </div>
                </div>
                <div class="item-detail">
                    <label>Kiểu số đẹp:</label>
                    <div class="lbl-content-detail">
                        <a href="{{ optional($sim_data['detail'])['categoryUrl'] }}" title="{{ optional($sim_data['detail'])['categoryText'] }}">
                            {{ optional($sim_data['detail'])['categoryText'] }}
                        </a>
                    </div>
                </div>
                @if(!$phone)
                    @if(!empty($sim_data['detail']['id']) && !empty(hung_cat_sim($sim_data['detail']['id'])))
                        <div class="item-detail">
                            <label>Đại cát:</label>
                            <div class="lbl-content-detail"><strong>{{ hung_cat_sim($sim_data['detail']['id']) }}</strong></div>
                        </div>
                    @endif
                @endif
            </div>
            @if(isset($sim_data['detail']['inslm_detail']))
                <div class="col-50 tra-gop">
                    <section class="tra-gop-inner">
                        <h3><span>Ưu đãi trả góp</span></h3>
                        <div class="block-inner">
                            <label for="tra_truoc">Số tiền trả trước:</label>
                            <select id="tra_truoc" class="mb-10" onchange="tra_gop()">
                                @foreach($sim_data['detail']['inslm_detail']['tra_truoc'] as $tra_truoc=>$amount)
                                    <option value="{{ $tra_truoc }}" @if($sim_data['detail']['inslm_info']['tra_truoc'] == $tra_truoc) selected @endif>Trả trước {{ $tra_truoc }}% - {{ format_money($amount) }}</option>
                                @endforeach
                            </select>
                            <label for="ky_han">Thời gian trả góp:</label>
                            <select id="ky_han" class="mb-10" onchange="tra_gop()">
                                @foreach($sim_data['detail']['inslm_detail']['ky_han'] as $ky_han=>$tra_truoc)
                                    <option value="{{ $ky_han }}" @if($sim_data['detail']['inslm_info']['ky_han'] == $ky_han) selected @endif>Trả góp {{ $ky_han }} tháng</option>
                                @endforeach
                            </select>
                            <label for="so_tien_moi_thang">Dự kiến trả góp:
                                <span id="so_tien_moi_thang">{{ format_money($sim_data['detail']['inslm_info']['so_tien_moi_thang']) }}/tháng</span>
                            </label>
                            <textarea id="attributes" name="attributes" style="display: none"></textarea>
                        </div>
                    </section>
                </div>
                <script type="text/javascript">
                    function tra_gop(){
                        const tra_truoc = document.getElementById('tra_truoc');
                        const ky_han = document.getElementById('ky_han');
                        const $inslm_detail = {!! json_encode($sim_data['detail']['inslm_detail']['ky_han']) !!};
                        const $attributes = $inslm_detail[ky_han.value][tra_truoc.value];
                        const so_tien_moi_thang = document.getElementById('so_tien_moi_thang');
                        let VND = new Intl.NumberFormat('vi-VN', {
                            style: 'currency',
                            currency: 'VND',
                        });
                        so_tien_moi_thang.innerText = `${VND.format($attributes['so_tien_moi_thang'])}/tháng`;
                        document.getElementById('attributes').value = JSON.stringify($attributes);
                        const btnTraGop = document.getElementById('tra_gop');
                        if(btnTraGop){
                            btnTraGop.innerText = VND.format($attributes['so_tien_moi_thang']);
                        }
                    }
                    tra_gop();
                </script>
            @else
                <div class="col-50 view_pc">
                    <img src="{{ config('constant.cdn_sim_card').'/'.$sim_data['detail']['id'].'.webp' }}" alt="" class="lazy">
                </div>
            @endif
        </div>
    </section>
    <section class="con-box-border form-order">
        <h2>Đặt mua sim</h2>
        @error('message')
        <div class="invalid-feedback-message">
            {{ $message }}
        </div>
        @enderror
        <div class="form-group">
            <div class="mb-3">
                <label for="fullname" class="form-label">Họ tên*:</label>
                <input type="text" class="form-control @error('fullname') is-invalid @enderror" @if(!$mobile) autofocus @endif id="fullname" placeholder="Họ và tên của bạn"
                       name="fullname" value="{{ old('fullname') }}" oninvalid="this.setCustomValidity('Vui lòng nhập họ & tên')" oninput="setCustomValidity('')" required>
                @error('fullname')
                <div id="fullNameError" class="form-text-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Điện thoại liên hệ*:</label>
                <input class="form-control @error('phone') is-invalid @enderror" type="tel" id="phone" name="phone" placeholder="Điện thoại liên hệ" value="{{ old('phone') }}" oninvalid="this.setCustomValidity('Nhập số điện thoại quý khách đang sử dụng')" oninput="setCustomValidity('')" required>
                @error('phone')
                <div id="phoneError" class="form-text-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ*:</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Địa chỉ nhận sim" name="address" value="{{ old('address') }}" oninvalid="this.setCustomValidity('Nhập địa chỉ nhận sim')" oninput="setCustomValidity('')" required>
                @error('address')
                <div id="addressError" class="form-text-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="other_option" class="form-label">Yêu cầu khác:</label>
                <input type="text" class="form-control" id="other_option" value="{{ old('other_option') }}"
                       placeholder="Yêu cầu khác (Không bắt buộc)" name="other_option">
            </div>
            <div class="mb-3 form-check">
                <label class="detail_form_checkbox">
                    <input value="{{ \App\Enums\PaymentType::COD }}" checked type="radio" name="payment_method">
                    <span class="ic ic-check-circle"></span> Thanh toán khi nhận sim
                </label>
                <label class="detail_form_checkbox">
                    <input value="{{ \App\Enums\PaymentType::BANK }}" type="radio" name="payment_method">
                    <span class="ic ic-check-circle"></span> Thanh toán online (chuyển khoản)
                </label>
            </div>
            <div class="mb-3 form-check" style="display: none">
                <label class="detail_form_checkbox">
                    <input type="checkbox" name="invoice" value="1" id="invoice">
                    <span class="ic ic-check-circle"></span> Xuất hoá đơn công ty
                </label>
                <div class="mb-10" id="masothue">
                    <input type="text" name="mst" class="form-control" placeholder="Mã số thuế">
                    <div class="form-text">Nhân viên CSKH sẽ gọi lại để xác nhận thông tin doanh
                        nghiệp của bạn</div>
                </div>
            </div>
            <div class="text-center">
                <div class="d-flex justify-content-center align-items-center mt-10 mb-10 gap-10">
                    @if(isset($sim_data['detail']['inslm_detail']))
                        <button type="button" class="btn-submit-tra-gop" onclick="orderSubmit(this, '{{ \App\Enums\OrderType::INSTALLMENT }}')">
                            <span>Mua trả góp</span>
                            <span>Chỉ <span id="tra_gop">{{ format_money($sim_data['detail']['inslm_info']['so_tien_moi_thang']) }}</span>/tháng</span>
                        </button>
                        <button type="button" class="btn-submit" onclick="orderSubmit(this, '{{ \App\Enums\OrderType::COMMON }}')">
                            <span>Mua ngay</span>
                            @if(isset($sim_data['detail']['sell_price']))
                                <span>Giá {!! format_money($sim_data['detail']['sell_price']) !!}</span>
                            @else
                                <span>Giá {!! optional($sim_data['detail'])['priceFormatted'] !!}</span>
                            @endif
                        </button>
                    @else
                        <button type="button" class="btn-submit btn-khong-tra-gop" onclick="orderSubmit(this, '{{ \App\Enums\OrderType::COMMON }}')">
                            <span>Mua ngay</span>
                            <span>Giao sim nhanh miễn phí toàn quốc</span>
                        </button>
                    @endif
                </div>
                <div id="page_loader" style="display: none">
                    <div class="logo"></div>
                    <div class="loader"></div>
                </div>
            </div>
        </div>
    </section>
    <textarea id="historyBrowser" name="browse_history" style="display: none"></textarea>
    <input type="submit" id="submit" style="display: none"/>
    <input type="hidden" id="_pk_id" name="_pk_id" value="">
    <input type="hidden" id="time_to_submit" name="time_to_submit" value="">
</form>
<section class="con-box-border guid-buy">
    <h2>Thủ tục đăng ký chính chủ sim:</h2>
    <p>- Căn cước công dân bản gốc hoặc Hộ chiếu bản gốc của chủ thuê bao</p>
    <p>- Chủ thuê bao nhận sim trực tiếp để làm thủ tục đăng ký</p>
    <p><i>Quý khách vui lòng chuẩn bị trước để cung cấp cho nhân viên đăng ký khi giao dịch mua sim.</i></p>
</section>
<script type="text/javascript">
    let startTime;
    document.querySelectorAll('#formOrder input').forEach(input => {
        input.addEventListener('input', handleInputStart, { once: true });
    });
    function handleInputStart(event) {
        if (!startTime) {
            startTime = new Date();
        }
    }
    function orderSubmit(el, type)
    {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'order_type';
        input.value = type;
        const form = document.getElementById('formOrder');
        form.appendChild(input);
        document.getElementById('_pk_id').value = getVisitorId();
        const btnSubmit = document.getElementById('submit');
        if(btnSubmit){
            if(typeof startTime !== 'undefined'){
                const endTime = new Date();
                document.getElementById('time_to_submit').value = endTime - startTime;
            }
            setTimeout(function (){
                btnSubmit.click();
            }, 100);
        }
        form.addEventListener('submit', function (){
            el.disabled = true;
            const loader = document.getElementById('page_loader');
            if(loader){
                loader.style.display = 'block';
            }
        });
    }
    function getVisitorId() {
        const cookies = document.cookie.split('; ');
        for (let i = 0; i < cookies.length; i++) {
            if (cookies[i].startsWith('_pk_id.')) {
                const cookieValue = cookies[i].split('=')[1];
                return cookieValue.split('.')[0];
            }
        }
        return null;
    }
</script>
