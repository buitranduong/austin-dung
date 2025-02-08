@props([
    'active_filter_items'=>[],
    'items'=>[],
    'is_button'=> true,
])
@foreach($items as $item)
    @php
        $href = "javascript: toggleFilterWithLink('c','".$item['c']."', '".$item['link']."', 1)";
        $role="button";
        if(!$is_button) {
            $href = $item['link'];
            $role="link";
        }
    @endphp
    @if(!isset($item['show_filter']) or $item['show_filter'])
    <div class="sim-card-item {{ in_array('c_'.$item['c'], $active_filter_items['active_keys'] ?? []) ? 'check' : '' }}">
        <a href="{{ $href }}" role="{{ $role }}" title="{{ $item['title'] }}">{{ $item['title'] }}</a>
    </div>
    @endif
@endforeach