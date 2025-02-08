@props([
    'active_filter_items'=>[],
    'phong_thuy_query'=>''
])
@php($active_telco = collect($active_filter_items['active_items'])->where('key','t')->count())
@php($active_head = collect($active_filter_items['active_items'])->where('key','h')->count())
@php($active_type = collect($active_filter_items['active_items'])->where('key','c')->count())
@php($active_price = collect($active_filter_items['active_items'])->where('key','pr')->count())
@php($active_sort = collect($active_filter_items['active_items'])->where('key','d')->count())
<div class="advance_filter_block_new" id="advance_filter_block_new">
    <div class="advance_filter_content">
        <ul class="advanced_filter" id="advanced_filter">
            <li class="advanced-filter-mobile view_sp @if(isset($active_filter_items['active_keys']) && count($active_filter_items['active_keys']) > 0) active @endif">
                <div class="advanced-criteria">
                    @if(isset($active_filter_items['active_keys']) && count($active_filter_items['active_keys']) > 0)
                        <span class="bage">{{ count($active_filter_items['active_keys']) }}</span>
                    @endif
                    <span class="ico-filter01"></span>
                    <span class="view_sp">Lọc sim nâng cao</span>
                </div>
            </li>
            <li class="item-filter-pc view_pc-tab @if(isset($active_filter_items['active_keys']) && count($active_filter_items['active_keys']) > 0) active @endif">
                <div class="advanced-criteria">
                    <span class="ico-filter01"></span>
                    Bộ lọc
                    @if(isset($active_filter_items['active_keys']) && count($active_filter_items['active_keys']) > 0)
                        <span class="bage">{{ count($active_filter_items['active_keys']) }}</span>
                    @endif
                </div>
                <div id="advance_filter_pc" class="advance-filter-pc">
                    @include('components.theme.block.filters.adv-filter-all')
                </div>
            </li>
            <li class="filter-item list-filter-network view_pc-tab @if($active_telco) active @endif">
                <div class="advanced-criteria"><span class="ico-filter02"></span>Nhà Mạng</div>
                <div id="list-filter-network" class="advanced-list-price">
                    @foreach(\App\Enums\SimType::FILTER_TEL as $item)
                        @if(!isset($item['show_filter']) or $item['show_filter']==true)
                            <label class="{{ in_array('t_'.$item['t'], $active_filter_items['active_keys']) ? 'check' : '' }}">
                                <a class="adv-filter-telco adv-filter-t-{{ $item['t'] }}" href="javascript: toggleFilter('t','{{ $item['t'] }}', 1)" role="button"><i class="ic ic-{{ $item['key'] }}"></i></a>
                            </label>
                        @endif
                    @endforeach
                </div>
            </li>
            <li class="filter-item view_pc-tab @if($active_head) active @endif">
                <div class="advanced-criteria"><span class="ico-filter03"></span>Đầu số</div>
                <div id="list-filter-number" class="advanced-list-price">
                    @foreach(\App\Enums\SimType::FILTER_HEAD as $item)
                        <label class="{{ in_array('h_'.$item['h'], $active_filter_items['active_keys']) ? 'check' : '' }}">
                            <a class="adv-filter-head adv-filter-h-{{ $item['h'] }}" href="javascript: toggleFilter('h','{{ $item['h'] }}', 1)" role="button">{{ $item['label'] }}</a>
                        </label>
                    @endforeach
                </div>
            </li>
            <li class="filter-item view_pc-tab @if($active_type) active @endif">
                <div class="advanced-criteria"><span class="ico-filter04"></span>Kiểu số đẹp</div>
                <div id="list-filter-sim" class="advanced-list-price">
                    @foreach(\App\Enums\SimType::FILTER_CATES as $item)
                        @if(!isset($item['show_filter']) or $item['show_filter']==true )
                            <label class="{{ in_array('c_'.$item['c'], $active_filter_items['active_keys']) ? 'check' : '' }}">
                                <a class="adv-filter-cate adv-filter-c-{{ $item['c'] }}" href="javascript: toggleFilter('c','{{ $item['c'] }}', 1)" role="button">{{ $item['title'] }}</a>
                            </label>
                        @endif
                    @endforeach
                </div>
            </li>
            <li class="filter-item view_pc-tab @if($active_price) active @endif">
                <div class="advanced-criteria"><span class="ico-filter05"></span>Khoảng Giá</div>
                <div id="list-filter-price" class="advanced-list-price">
                    @foreach(\App\Enums\SimType::FILTER_PRICES as $item)
                        @if((!isset($item['show_filter']) or $item['show_filter']==true))
                            <label class="{{ in_array('pr_'.$item['pr'], $active_filter_items['active_keys']) ? 'check' : '' }}">
                                <a class="adv-filter-price adv-filter-pr-{{ $item['pr'] }}" href="javascript: toggleFilter('pr','{{ $item['pr'] }}', 1)" role="button">{{ $item['name'] }}</a>
                            </label>
                        @endif
                    @endforeach
                </div>
            </li>
            <li class="filter-item @if($active_sort) active @endif" id="list-filter-category">
                <div class="advanced-criteria"><span class="ico-filter06"></span>Sắp xếp </div>
                <div class="advanced-list-price">
                    @foreach(\App\Enums\SimType::FILTER_SORT as $i=>$item)
                        <label class="{{ (($i==0 and !request()->has('d')) or in_array('d_'.$item['d'], $active_filter_items['active_keys'])) ? 'check' : '' }}">
                            <a class="adv-filter-sort adv-filter-d-{{ $item['d'] }}" href="javascript: toggleFilter('d','{{ $item['d'] }}', 1)" role="button">{{ $item['title'] }}</a>
                        </label>
                    @endforeach
                </div>
            </li>
        </ul>
        @if(count($active_filter_items['active_items'] ?? [])>0)
            <div class="advance_choose-filter">
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
    </div>
    @include('components.theme.block.adv-filter-mobile')
</div>
