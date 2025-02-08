@props([
    'active_filter_items'=>[],
    'phong_thuy_query'=>''
])
<ul class="filter" id="filter">
    <li class="filter-item">
        <span class="criteria">Đầu số</span>
        <div id="list-filter-number" class="list-price">
            <label class="all @if(!request()->has('h')) check @endif">
                <a href="javascript: toggleFilter('h','{{ request()->get('h') }}', -1)" role="button"> Tất cả</a>
            </label>
            @foreach(\App\Enums\SimType::FILTER_HEAD as $item)
                <label class="{{ in_array('h_'.$item['h'], $active_filter_items['active_keys']) ? 'check' : '' }}">
                    <a class="prevent" href="javascript: toggleFilter('h','{{ $item['h'] }}', 1)" role="button">{{ $item['title'] }}</a>
                </label>
            @endforeach
        </div>
    </li>
    <li class="filter-item">
        <span class="criteria">Loại sim</span>
        <div id="list-filter-sim" class="list-price">
            <label class="all @if(!request()->has('c')) check @endif">
                <a href="javascript: toggleFilter('c','{{ request()->get('c') }}', -1)" role="button"> Tất cả</a>
            </label>
            @foreach(\App\Enums\SimType::FILTER_CATES as $item)
                @if(!isset($item['show_filter']) or $item['show_filter']==true )
                <label class="{{ in_array('c_'.$item['c'], $active_filter_items['active_keys']) ? 'check' : '' }}">
                    <a href="javascript: toggleFilter('c','{{ $item['c'] }}', 1)" role="button">{{ $item['title'] }}</a>
                </label>
                @endif
            @endforeach
        </div>
    </li>
    <li class="filter-item">
        <span class="criteria">Nhà Mạng</span>
        <div id="list-filter-network" class="list-price">
            <label class="all @if(!request()->has('t')) check @endif">
                <a href="javascript: toggleFilter('t','{{ request()->get('t') }}', -1)" role="button"> Tất cả</a>
            </label>
            @foreach(\App\Enums\SimType::FILTER_TEL as $item)
                @if(!isset($item['show_filter']) or $item['show_filter']==true )
                <label class="{{ in_array('t_'.$item['t'], $active_filter_items['active_keys']) ? 'check' : '' }}">
                    <a href="javascript: toggleFilter('t','{{ $item['t'] }}', 1)" role="button">{{ $item['title'] }}</a>
                </label>
                @endif
            @endforeach
        </div>
    </li>
    <li class="filter-item">
        <span class="criteria">Khoảng Giá</span>
        <div id="list-filter-price" class="list-price">
            <label class="all @if(!request()->has('pr')) check @endif">
                <a href="javascript: toggleFilter('pr','{{ request()->get('pr') }}', -1)" role="button"> Tất cả</a>
            </label>
            @foreach(\App\Enums\SimType::FILTER_PRICES as $item)
                @if(!isset($item['show_filter']) or $item['show_filter']==true)
                <label class="{{ in_array('pr_'.$item['pr'], $active_filter_items['active_keys']) ? 'check' : '' }}">
                    <a href="javascript: toggleFilter('pr','{{ $item['pr'] }}', 1)" role="button">{{ $item['title'] }}</a>
                </label>
                @endif
            @endforeach
        </div>
    </li>
    <li class="filter-item">
        <span class="criteria">Sắp xếp </span>
        <div id="list-filter-category" class="list-price">
            @foreach(\App\Enums\SimType::FILTER_SORT as $i=>$item)
                <label class="{{ (($i==0 and !request()->has('d')) or in_array('d_'.$item['d'], $active_filter_items['active_keys'])) ? 'check' : '' }}">
                    <a href="javascript: toggleFilter('d',{{ $item['d'] }}, 1)" role="button">{{ $item['title'] }}</a>
                </label>
            @endforeach
        </div>
    </li>
</ul>
@if(count($active_filter_items['active_items'] ?? [])>0)
<div class="choose-filter">
    @foreach($active_filter_items['active_items'] as $item)
        <a href="javascript:toggleFilter('{{ optional($item)['key'] }}', '{{ optional($item)['data'] }}', -1)" role="button"> {{ optional($item)['title'] }} <i class="ic-clearfil"></i></a>
    @endforeach
    @if(count($active_filter_items['active_items'])>1)
    <a id="choosedfilter" class="reset" href="javascript:resetFilters('{!! $phong_thuy_query !!}');">
        Xóa tất cả<i class="ic-clearfil"></i>
    </a>
    @endif
</div>
@endif
