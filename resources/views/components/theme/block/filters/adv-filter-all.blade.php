@props([
    'phong_thuy_query'=>''
])
<form action="" onSubmit="return handleFilterAdvForm(event, this, '{!! $phong_thuy_query !!}')" id="adv-form-search-pc">
    <div class="grid-container">
        <div class="grid-item item1">
            <h4 class="title-form-search">Mạng di động</h4>
            <div class="filter-item-tel filter-img">
                <ul>
                    @php
                        $active_keys = $active_filter_items['active_keys'] ?? [];
                    @endphp
                    @foreach(\App\Enums\SimType::FILTER_TEL as $item)
                        @php
                            $t = 't_'. $item['t'];
                            $check = array_item_startswith($t, $active_keys);
                        @endphp
                        @if(!isset($item['show_filter']) || $item['show_filter'] )
                            <li>
                                <input type="checkbox" name="check_tel" value="{{ $item['t'] }}" id="{{ $item['telco'] }}-pc" @if ($check) checked @endif>
                                <label for="{{ $item['telco'] }}-pc">
                                    <i class="ic ic-{{$item['telco']}}"></i>
                                </label>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="grid-item item2">
            <h4 class="title-form-search">Đầu số</h4>
            <div class="filter-item-tel prefix-number">
                <ul>
                    @foreach(\App\Enums\SimType::FILTER_HEAD as $item)
                        @php
                            $h = 'h_'. $item['h'];
                            $check = array_item_startswith($h, $active_keys);
                        @endphp
                        <li>
                            <input type="checkbox" name="check_head" value="{{ $item['h'] }}" id="{{ $item['name'] }}-pc" @if ($check) checked @endif>
                            <label for="{{ $item['name'] }}-pc">{{ $item['label'] }}</label>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
        <div class="grid-item item3">
            <h4 class="title-form-search">Khoảng giá</h4>
            <div class="filter-item-tel">
                <ul>
                    @php
                        $active_item = null;
                        foreach ($active_keys as $item) {
                            if (strpos($item, 'pr_') === 0) {
                                $active_item = str_replace('pr_', '', $item);
                                break;
                            }
                        }
                    @endphp
                    @foreach(\App\Enums\SimType::FILTER_PRICES as $item)
                        @if(!isset($item['show_filter']) or $item['show_filter']==true )
                            <li>
                                <input @if ($item['pr'] == $active_item) checked @endif type="radio" name="pr" id="sim-type-{{ $item['pr'] }}" value="{{ $item['pr'] }}">
                                <label for="sim-type-{{ $item['pr'] }}">{{ $item['name'] }}</label>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="grid-item item4">
            <h4 class="title-form-search">Loại trừ số (không tính 2 số đầu)</h4>
            <div class="filter-item-tel prefix-first-number">
                <ul>
                    @foreach([0,1,2,3,4,5,6,7,8,9,49,53] as $i)
                        @php
                            $t = 'notIn_'. $i;
                            $check = array_item_startswith($t, $active_keys);
                            if((in_array('notIn_4', $active_keys) && in_array('notIn_9', $active_keys) && $i == 49) or
                                (in_array('notIn_3', $active_keys) && in_array('notIn_5', $active_keys) && $i == 53))
                            {
                                $check = true;
                            }
                        @endphp
                        <li>
                            <input type="checkbox" name="notIn" id="tranh_{{ $i }}" value="{{ $i }}" @if ($check) checked @endif>
                            <label for="tranh_{{ $i }}">{{ $i }}</label>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="grid-item item5">
            <h4 class="title-form-search">Kiểu số đẹp</h4>
            <div class="filter-item-tel prefix-number">
                @php
                    $active_cates = false;
                    $active_item = null;
                    foreach ($active_keys as $item) {
                        if (strpos($item, 'c_') === 0) {
                            $active_cates = true;
                            $active_item = str_replace('c_', '', $item);
                            break;
                        }
                    }
                @endphp
                <div class="d-flex select-block select-cates {{ $active_cates ? 'active':'' }}">
                    <div class="i-select">
                        <select name="cate" id="filter_cate" onchange="activeSelect(this, 'select-cates');">
                            <option value="">Tất cả</option>
                            @foreach(\App\Enums\SimType::FILTER_CATES as $item)
                                @if(!isset($item['show_filter']) or $item['show_filter']==true )
                                    <option @if ($item['c'] == $active_item) selected @endif value="{{ $item['c'] }}">{{ $item['title'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-item item6">
            <h4 class="title-form-search">Sắp xếp theo</h4>
            <div class="filter-item-tel">
                <ul>
                    @foreach(\App\Enums\SimType::FILTER_SORT as $item)
                        @php
                            $t = 'd_'. $item['d'];
                            $check = array_item_startswith($t, $active_keys);
                        @endphp
                        <li>
                            <input type="radio" name="d" id="d_{{ $item['d'] }}" value="{{ $item['d'] }}" @if ($check) checked @endif>
                            <label for="d_{{ $item['d'] }}">{{ $item['title'] }}</label>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="grid-item item7 btn-group-filter">
            <button class="btn-reset" type="reset" @if(count($active_filter_items['active_items'] ?? [])>0) onclick="resetFilters('{!! $phong_thuy_query !!}');" @endif>Thiết lập lại</button>
            <button class="btn-apply" type="submit">Áp dụng</button>
        </div>
    </div>
</form>
