@props([
    'active_filter_items'=>[],
    'items'=>[]
])
<ul class="filter view_tab-sp" id="filter">
    <li class="advanced-filter">
        <span class="criteria">Lọc sim nâng cao</span>
    </li>
    <li class="filter-item">
        <span class="criteria">Sắp xếp</span>
        <div id="list-filter-order" class="list-price" style="display: none;">
            <!-- <label class="{{ !array_item_startswith('d_', $active_filter_items['active_keys'] ?? []) ? 'check' : '' }}">
                <a href="javascript: toggleFilter('d','', -1)" role="button">Sim nổi bật</a>
            </label> -->
            @foreach($items as $item)
                <label class="{{ in_array('d_'.$item['d'], $active_filter_items['active_keys'] ?? []) ? 'check' : '' }}">
                    <a href="javascript: toggleFilter('d',{{ $item['d'] }}, 1)" role="button">{{ $item['title'] }}</a>
                </label>
            @endforeach
        </div>
    </li>
</ul>