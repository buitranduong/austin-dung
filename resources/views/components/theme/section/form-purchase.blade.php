<form id="order_form" name="order_form" method="post" action="{{ route('purchase.success') }}" class="order-form">
    @csrf
    <h3>Vui lòng cung cấp các thông tin sau:</h3>
    <div class="order-form-inner" style="text-align: left">
        <input autofocus="" placeholder="Số muốn BÁN hoặc CẦM CỐ" name="hoten" type="text" id="hoten" value="{{ old('hoten') }}"><br>
        @error('hoten')
        <span style="color: red">{{ $message }}</span>
        @enderror
        <input placeholder="Giá mong muốn" name="diachi" type="number" id="diachi" value="{{ old('diachi') }}"><br>
        @error('diachi')
        <span style="color: red">{{ $message }}</span>
        @enderror
        <input placeholder="Điện thoại liên hệ" name="dienthoai" type="tel" id="dienthoai" value="{{ old('dienthoai') }}"><br>
        @error('dienthoai')
        <span style="color: red">{{ $message }}</span>
        @enderror
        <input id="submit-datsim" type="submit" value="Gửi thông tin cho chúng tôi" class="btn-mua submit-ban-sim" style="font-size: 18px;padding: 5px 10px;width: 100%;margin-top: 10px;">
    </div>
</form>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const formOrder = document.getElementById('order_form');
        if(formOrder){
            formOrder.addEventListener('submit', function() {
                const inputSubmit = document.getElementById('submit-datsim');
                inputSubmit.disabled = true;
            });
        }
    });
</script>
