@props([
    'items'=>[],
    'as'=>''
])
@if($as == 'search-related')
    <section id="search-related" class="search-related">
        <h3 class="search-related-title">MỌI NGƯỜI CŨNG TÌM KIẾM</h3>
        <div class="row">
            @if($items)
                @foreach($items as $related)
                    <a class="search-related_item" href="{{ optional($related)['link'] }}">{{ optional($related)['title'] }}</a>
                @endforeach
            @endif
        </div>
    </section>
@else
<div class="category-filter-price view_pc">
    <div class="scroll-x home-filter">
        <div class="clearfix">
            @if($items)
                @foreach($items as $related)
                    <div class="sim-card-item"><a href="{{ optional($related)['link'] }}">{{ optional($related)['title'] }}</a></div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endif
