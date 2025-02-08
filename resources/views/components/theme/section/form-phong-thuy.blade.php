<div class="form_phongthuy">
    <form class="frm-phongthuy" name="search" method="get" action="">
        <div class="frm_phongthuy-inner">
            <div id="phongthuyloading" class="form_phongthuy_controls box-loading hide">
                <img style=" width: 130px; " src="/static/theme/images/phongthuy/simthanglong-phongthuy.gif" class="lazy" alt="">
            </div>
            @if(app('request')->routeIs('xem-phong-thuy-sim'))
            <div class="form_phongthuy_controls">
                <div class="form_phongthuy_controls-wrap">
                    <div class="form_left">
                        <label>Số điện thoại:</label>
                    </div>
                    <div class="form_right">
                        <input oninvalid="this.setCustomValidity('Vui lòng nhập số sim')" oninput="setCustomValidity('')" required autofocus value="{{ request()->get('sim') }}" type="tel" placeholder="Nhập số sim" class="form_controls_text" name="sim" id="sosim">
                    </div>
                </div>
            </div>
            @endif
            <div class="form_phongthuy_controls">
                <div class="form_phongthuy_controls-wrap">
                    <div class="form_left">
                        <label for="giosinh">Giờ sinh:&nbsp;</label>
                    </div>
                    <div class="form_right">
                        <select aria-label="giờ sinh" style="width:120px;" class="combobox" name="gs" id="giosinh">
                            @foreach(\App\Supports\PhongThuy\Constant::$gioSinh as $i=>$text)
                                <option @if(request()->get('gs')==$i) selected @endif value="{{ $i }}">{{ $text }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form_phongthuy_controls">
                <div class="form_phongthuy_controls-wrap">
                    <div class="form_left">
                        <label>Ngày&nbsp;sinh(DL):&nbsp;</label>
                    </div>
                    <div class="form_right">
                        <select aria-label="ngày sinh" class="combobox" name="ns" id="ngaysinh">
                            <option disabled>Ngày</option>
                            @for($i=1;$i<=31;$i++)
                                <option @if((!request()->has('ns') && $i==1) || request()->get('ns')==$i) selected @endif value="{{ $i<10?"0$i":$i }}">{{ $i<10?"0$i":$i }}</option>
                            @endfor
                        </select>
                        <select aria-label="tháng sinh" class="combobox" name="ts" id="thangsinh">
                            <option disabled>Tháng</option>
                            @for($i=1;$i<=12;$i++)
                                <option @if((!request()->has('ts') && $i==1) || request()->get('ts')==$i) selected @endif value="{{ $i<10?"0$i":$i }}">{{ $i<10?"0$i":$i }}</option>
                            @endfor
                        </select>
                        <select aria-label="năm sinh" class="combobox combobox_namsinh" name="ls" id="namsinh">
                            @for($i=1950;$i<=2025;$i++)
                                <option @if(($i==$year && !request()->has('ls')) || request()->get('ls')==$i) selected @endif value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="form_phongthuy_controls">
                <div class="form_phongthuy_controls-wrap">
                    <div class="form_left">
                        <label>Giới tính:&nbsp;&nbsp;</label>
                    </div>
                    <div class="form_right">
                        <div class="radio_box">
                            <input @if(request()->get('gt')!='nu') checked @endif type="radio" id="radio_1" value="nam" name="gt">
                            <label for="radio_1">Nam</label>
                        </div>
                        <div class="radio_box">
                            <input @if(request()->get('gt')=='nu') checked @endif type="radio" id="radio_2" value="nu" name="gt">
                            <label for="radio_2">Nữ</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form_phongthuy_controls">
                <div class="form_phongthuy_controls-wrap">
                    <button type="submit" class="btn-phongthuy" id="button" name="ft" value="1">Tìm sim hợp tuổi</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const formOrder = document.getElementById('frm-phongthuy');
        if(formOrder){
            formOrder.addEventListener('submit', function() {
                const btnSubmit = document.querySelectorAll('button[type="submit"]');
                if(btnSubmit && btnSubmit.length){
                    Array.from(btnSubmit).forEach(function (btn){
                        btn.disabled = true;
                    });
                }
            });
        }
    });
</script>
