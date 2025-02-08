<h3 class="menu_title"><i class="ic ic-sim"></i> Mạng di động</h3>
<ul class="list-filter-item scroll-x">
    @foreach(\App\Enums\SimType::FILTER_TEL as $item)
        @if(!isset($item['show_mobile']) || $item['show_mobile'] )
            <li>
                <a href="{{ $item['link'] }}" title="{{ $item['title'] }}" aria-label="{{ $item['title'] }}">
                    <i class="ic ic-{{ $item['telco'] }}"></i>
                </a>
            </li>
        @endif
    @endforeach
</ul>
<ul class="list-filter-item col-5 mb-18">
    @foreach(\App\Enums\SimType::FILTER_HEAD as $item)
        @if(!isset($item['show_mobile']) or $item['show_mobile']==true )
            <li>
                <a href="{{ $item['link'] }}.html" title="{{ $item['title'] }}">{{ $item['name'] }}</a>
            </li>
        @endif
    @endforeach
</ul>
<h3 class="menu_title"><i class="ic ic-sim"></i> Khoảng giá</h3>
<ul class="list-filter-item price-number mb-18">
    @foreach(\App\Enums\SimType::FILTER_PRICES as $item)
        @if(!isset($item['show_mobile']) or $item['show_mobile']==true )
            <li>
                <a href="{{ $item['link'] }}" title="{{ $item['title'] }}">{{ $item['label'] }}</a>
            </li>
        @endif
    @endforeach
</ul>
<h3 class="menu_title"><i class="ic ic-sim"></i> Kiểu số đẹp</h3>
<ul class="list-filter-item beauty-number">
    @foreach(\App\Enums\SimType::FILTER_CATES as $item)
        @if(!isset($item['show_mobile']) or $item['show_mobile']==true )
            <li>
                <a href="{{ $item['link'] }}" title="{{ $item['title'] }}">{{ $item['title'] }}</a>
            </li>
        @endif
    @endforeach
</ul>
