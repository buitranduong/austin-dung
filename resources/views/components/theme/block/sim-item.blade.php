@props([
    'sim'=>[
         'telcoText'=>'',
         'id'=>'',
         'highlight'=>'',
         'pn'=>'',
         'sell_price'=>'',
         'adjust_percent'=>'',
         'inslm_info'=>''
    ],
    'color'=>'sim-price',
    'i'=>'',
    'as'=>'a'
])
@if($as == 'tr')
    <tr>
        <td><span class="sott">{{ $i+1 }}</span></td>
        <td class="simso">
            <a href="/{{ $sim['id'] }}" title="{{ $sim['id'] }}">{!! $sim['highlight'] !!}</a>
        </td>
        <td>
            @if(empty($sim['inslm_info']))
                <span class="text-price">{!! format_money($sim['sell_price'] ?? $sim['pn']) !!}</span>
                @if(!empty($sim['sell_price']) && $sim['adjust_percent'] < 0)
                <span class="text-price-old">{!! format_money($sim['pn']) !!}</span>
                @endif
            @else
                <span class="text-price">{!! format_money($sim['pn']) !!}</span>
{{--                <span class="text-tra-gop">Trả góp {!! format_money_k($sim['inslm_info']['so_tien_moi_thang']) !!}/tháng</span>--}}
            @endif
        </td>
        <td><span class="ic ic-{{ $sim['telcoText'] }}">{{ $sim['telcoText'] }}</span></td>
        <td><span class="cat2">{{ $sim['categoryText'] }}</span></td>
        <td><a href="{{ $sim['id'] }}" class="btn-buy">Mua ngay</a></td>
    </tr>
@else
    <a class="sim-card {{ $sim['telcoText'] }}" href="/{{ $sim['id'] }}">
        <div class="sim-number">{!! $sim['highlight'] !!}</div>
        <div class="{{ $color }}">{!! format_money($sim['sell_price'] ?? $sim['pn']) !!}</div>
        @if(!empty($sim['sell_price']) && $sim['adjust_percent'] < 0)
            <div class="sim-price-old">{!! format_money($sim['pn']) !!}</div>
{{--        @elseif(!empty($sim['inslm_info']))--}}
{{--            <div class="sim-tra-gop">Trả góp {{ format_money_k($sim['inslm_info']['so_tien_moi_thang'] ?? 0) }}/tháng</div>--}}
        @endif
    </a>
@endif
