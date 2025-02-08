@props([
    'data'=>[],
    'sim'=>[
        'id',
        'telco',
        'path',
        'tail'
    ],
    'mobile'=>false
])
@if(!empty($sim['id']))
<section class="sim-da-ban">
    <h1>Sim {{ $sim['id'] }}</h1>
    <div class="con-box-border con-sim-da-ban">
        <div class="col-50">
            <div class="item-detail">
                <label>Số sim:</label>
                <div class="lbl-content-detail simso">{{ $sim['id'] }}</div>
            </div>
            <div class="item-detail">
                <label>Giá bán:</label>
                <div class="lbl-content-detail sim-price">Số đã bán</div>
            </div>
            <div class="item-detail">
                <label>Mạng:</label>
                <div class="lbl-content-detail">
                    <i class="ic ic-{{ $sim['telco'] }}"></i>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@if(!empty($data) && !empty($sim['id']))
    <section class="{{ !$mobile ? 'page-category' : 'sim-trong-kho' }}">
        <h2 style="font-size: 110%">Mời bạn tham khảo số gần giống đang còn trong kho</h2>
        @if(!$mobile)
            <x-theme.section.table-sim :$data/>
        @else
            <x-theme.section.list-sim :$data/>
        @endif
        <div class="text-center mt-20 mb-20">
            <a href="{{ $sim['path'] }}" class="btn-buy">Xem thêm sim *{{ $sim['tail'] }}</a>
        </div>
    </section>
@endif
