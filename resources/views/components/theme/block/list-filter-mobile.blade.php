@props([
    'active_filter_items'=>[],
    'heads' => null,
    'phong_thuy_query'=>''
])
<div class="scroll-x home-filter view_tab-sp">
    <div class="clearfix">
        @if($heads && count($heads ?? []) > 1)
            <x-theme.block.filters.filter-heads :$heads :$active_filter_items/>
        @else
        <div style="display: none" class="sim-card-item sim-card-net">
            <a href="javascript: toggleFilterWithLink('h','09', '/sim-dau-so-$item', 1)" title="Sim số đầu 09" role="button">09x</a>
        </div>
        <div style="display: none" class="sim-card-item sim-card-net">
            <a href="javascript: toggleFilterWithLink('h','08', '/sim-dau-so-$item', 1)" title="Sim số đầu 08" role="button">08x</a>
        </div>
        @endif
        @if(!$heads)
            <x-theme.block.filters.filter-tel :items="\App\Enums\SimType::FILTER_TEL" :$active_filter_items/>
        @endif
    </div>
</div>
<div class="scroll-x home-filter view_tab-sp pt-10">
    <div class="clearfix">
        <x-theme.block.filters.filter-prices :items="\App\Enums\SimType::FILTER_PRICES" :$active_filter_items/>
    </div>
</div>
<x-theme.block.filters.filter-sort :items="\App\Enums\SimType::FILTER_SORT" :$active_filter_items />

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
