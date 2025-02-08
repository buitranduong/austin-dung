@props([
    'active_filter_items'=>[],
    'items'=>[],
    'is_button'=> true,
])
@foreach($items as $item)
    <div class=" sim-card-item">
        @php
            $href = "javascript: toggleFilterWithLink('t','".$item['t']."', '".$item['link']."', 1)";
            $role="button";
            if(!$is_button) {
                $href = $item['link'];
                $role="link";
            }
        @endphp
        @if(!isset($item['show_filter']) || $item['show_filter'])
        <a href="{{ $href }}" class="active1" aria-label="{{ $item['telco'] }}" role="{{ $role }}" title="{{ $item['title'] }}">
            <i class="ic ic-{{ $item['telco'] }}"></i>
        </a>
        @endif
    </div>
@endforeach