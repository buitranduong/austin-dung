@props([
    'title'=>'',
    'items'=>[]
])
<div class="list-group">
    <div class="corner corner-brown corner-top-left">
        <div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="corner corner-brown corner-bottom-left">
        <div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="corner corner-brown corner-top-right">
        <div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="corner corner-brown corner-bottom-right">
        <div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="border-brown">
        @if(!empty($title))
            <h2 class="list-group-title active">{{ $title }}</h2>
        @endif
        @if($slot->isNotEmpty())
           {!! $slot !!}
        @else
            @foreach($items as $item)
                <a class="list-group-item lgit" href="{{ $item['link'] }}">{{ $item['title'] }}</a>
            @endforeach
        @endif
    </div>
</div>
