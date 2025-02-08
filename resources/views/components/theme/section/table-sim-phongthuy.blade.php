@props([
    'data'=>'',
    'mobile'=>false
])
@if(!empty($data))
    <table class="tbl-category-pc">
        <tbody>
        @foreach($data as $sim)
            <tr>
                <td class="simso"><a href="{{ $sim['id'] }}" title="{{ $sim['id'] }}">{!! $sim['highlight'] !!}</a></td>
                <td class="text-right"><span class="text-pt-price">{!! $sim['priceFormatted'] !!}</span></td>
                <td><span class="ic ic-{{ \Illuminate\Support\Str::lower($sim['telcoText']) }} ic-pt-small">{{ $sim['telcoText'] }}</span></td>
                <td class="diem">
                    <div class="text-10">
                        {{ $sim['pt'] }}/10 <span class="view_pc view_tab-sp">&nbsp;điểm</span>
                    </div>
                </td>
                <td>
                    <a href="{{ route('xem-phong-thuy-sim', array_merge(request()->query(), ['sim'=>$sim['id']])) }}" class="link-dien-giai">
                        {{ $mobile ? 'Diễn giải' : 'Xem diễn giải' }}
                    </a>
                </td>
                <td class="view_pc">
                    <a href="{{ $sim['id'] }}" class="btn-buy">Mua ngay</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
