@props([
    'heads'=>[],
])
@foreach($heads as $item)
    <div class="sim-card-item sim-card-net">
        @php
            $href = "javascript: toggleFilterWithLink('h','".str_replace('x','',$item)."', '/sim-dau-so-$item', 1)";
            $role="button";
            
        @endphp
        <a  href="{{ $href }}" class="active1" aria-label="{{ $item }}" role="{{ $role }}" title="Sim đầu số {{ $item }}">
        {{ $item }}
        </a>
    </div>
@endforeach