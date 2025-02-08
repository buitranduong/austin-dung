@props([
    'title'=>'',
    'items'=>[]
])
<div class="list-group">
    <h3>{{ $title }}</h3>
    <div class="list-menu">
        <ul>
            @foreach($items as $item)
                <li>
                    <a href="{{ $item['link'] }}" title="{{ $item['title'] }}">{{ $item['title'] }}</a>
                </li>
            @endforeach
            <li class='range-price-filter'><span>Tùy chọn khoảng giá</span></li>
        </ul>
    </div>
</div>
