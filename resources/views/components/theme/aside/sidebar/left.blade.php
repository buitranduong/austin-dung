@props([
    'title'=>'',
    'items'=>[]
])
<div class="list-group">
    <h3>{{ $title }}</h3>
    <div class="list-menu">
        <ul>
            @foreach($items as $item)
                @if(!isset($item['show_filter']) or $item['show_filter']==true )
                <li>
                    <a href="{{ $item['link'] }}" title="{{ $item['title'] }}">{{ $item['title'] }}</a>
                </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
