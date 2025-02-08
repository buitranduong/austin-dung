<div class="d-flex align-center">
    <h6 class="form-label fw-bold">{{ __('Chú giải thuộc tính Sim') }}</h6>
    <small class="ms-2 text-danger fst-italic">*Chọn để copy</small>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Số sim (không định dạng):</span>
    <span class="input-group-text text-danger">0328979179</span>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.id]" readonly/>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Số sim (có định dạng):</span>
    <span class="input-group-text text-danger">0328.<i>979.179</i></span>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.highlight]" readonly/>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Giá sim (không định dạng):</span>
    <span class="input-group-text text-danger">2200000</span>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.pn]" readonly/>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Giá sim (có định dạng):</span>
    <span class="input-group-text text-danger">2.200.000₫</span>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.priceFormatted]" readonly/>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Nhà mạng:</span>
    <span class="input-group-text text-danger">viettel</span>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.telcoText]" readonly/>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Loại sim:</span>
    <span class="input-group-text text-danger">Sim Thần Tài</span>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.categoryText]" readonly/>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Số theo vị trí trong sim:</span>
    <span class="input-group-text text-danger">0328979179</span>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.f0]" readonly/>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.f1]" readonly/>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.f2]" readonly/>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.f3]" readonly/>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.f4]" readonly/>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.f5]" readonly/>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.f6]" readonly/>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.f7]" readonly/>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.f8]" readonly/>
    <input type="text" class="form-control copy-input" data-bs-toggle="tooltip" data-bs-title="Click để copy" value="[sim.f9]" readonly/>
</div>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const copyInput = document.querySelectorAll('.copy-input');
        if(copyInput) {
            copyInput.forEach(function (input){
                input.addEventListener('click', function () {
                    this.select();
                    navigator.clipboard.writeText(this.value).then(function() {
                        const tooltipInstance = bootstrap.Tooltip.getInstance(input);
                        tooltipInstance.setContent({ '.tooltip-inner': 'Đã copy, ctrl + v hoặc paste để sử dụng'});
                    }).catch(function(error) {
                        alert('Không thể sao chép: ' + error);
                    });
                });
                input.addEventListener('mouseover', function (){
                    const tooltipInstance = bootstrap.Tooltip.getInstance(input);
                    tooltipInstance.setContent({ '.tooltip-inner': 'Click để copy'});
                })
            });
        }
    })
</script>
