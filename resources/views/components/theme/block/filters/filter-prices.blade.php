@props([
    'active_filter_items'=>[],
    'items'=>[],
    'is_button'=>true,
])
@foreach($items as $item)
    @php
        $href = "javascript: toggleFilterWithLink('pr','".$item['pr']."', '".$item['link']."', 1)";
        $role="button";
        if(!$is_button) {
            $href = $item['link'];
            $role="link";
        }
    @endphp
    <div class="sim-card-item {{ in_array('pr_'.$item['pr'], $active_filter_items['active_keys'] ?? []) ? 'check' : '' }}">
        <a href="{{ $href }}" role="{{ $role }}" title="{{ $item['title'] }}">{{ $item['name'] }}</a>
    </div>
@endforeach