@props([
    'sim_setting' => '',
    'sorts' => '',
    'providers' => '',
    'action' => '',
    'before' => '',
    'after' => '',
])
{!! $errors->first() !!}
<form accept-charset="utf-8" action="{{ $action }}" method="post">
    @csrf
    {!! $before !!}
    <div class="mb-3">
        <label for="priority_sims" class="form-label fw-bold">{{ __('Số ưu tiên') }}</label>
        <textarea class="form-control" id="priority_sims" name="sim_setting[priority_sims]" autocomplete="off">{!! isset($sim_setting['priority_sims']) ? implode("&#13;&#10;", $sim_setting['priority_sims']) : '' !!}</textarea>
        <div class="form-text fst-italic text-danger-emphasis">(Có thể nhập nhiều ID, mỗi ID cách nhau bởi một lần xuống
            dòng)</div>
    </div>
    <div class="mb-3">
        <label for="priority_warehouse" class="form-label fw-bold">{{ __('Kho ưu tiên') }}</label>
        <textarea class="form-control" id="priority_warehouse" name="sim_setting[priority_warehouse]" autocomplete="off">{!! isset($sim_setting['priority_warehouse']) ? implode("&#13;&#10;", $sim_setting['priority_warehouse']) : '' !!}</textarea>
        <div class="form-text fst-italic text-danger-emphasis">(Có thể nhập nhiều ID, mỗi ID cách nhau bởi một lần xuống
            dòng)</div>
    </div>
    <div class="mb-3">
        <label for="priority_price_min" class="form-label fw-bold">{{ __('Ưu tiên Giá lớn hơn') }}</label>
        <div class="input-group">
            <input inputmode="decimal" type="text" class="form-control" id="priority_price_min"
                name="sim_setting[priority_price_min]" value="{{ $sim_setting['priority_price_min'] ?? '' }}"
                autocomplete="off">
            <span class="input-group-text">đ</span>
        </div>
        @error('sim_setting.priority_price_min')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="priority_price_max" class="form-label fw-bold">{{ __('Ưu tiên Giá nhỏ hơn') }}</label>
        <div class="input-group">
            <input inputmode="decimal" type="text" class="form-control" id="priority_price_max"
                name="sim_setting[priority_price_max]" value="{{ $sim_setting['priority_price_max'] ?? '' }}"
                autocomplete="off">
            <span class="input-group-text">đ</span>
        </div>
        @error('sim_setting.priority_price_max')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="sort_default" class="form-label fw-bold">{{ __('Mặc định sắp xếp') }}</label>
        <select id="sort_default" name="sim_setting[sort_default]" class="form-select form-select-sm"
            aria-label="Small select example">
            @foreach ($sorts as $value => $label)
                <option value="{{ $value }}" @if (!empty($sim_setting['sort_default']) && $sim_setting['sort_default'] == $value) selected @endif>
                    {{ __($label) }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="priority_provider" class="form-label fw-bold">{{ __('Ưu tiên Nhà mạng') }}</label>
        <select id="priority_provider" name="sim_setting[priority_provider]" class="form-select form-select-sm"
            aria-label="Small select example">
            <option value="">----------</option>
            @foreach ($providers as $tel)
                <option value="{{ $tel['id'] }}" @if (!empty($sim_setting['priority_provider']) && $sim_setting['priority_provider'] == $tel['id']) selected @endif>{{ $tel['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="dieu-kien-query" class="form-label fw-bold">{{ __('Điều kiện query bắt buộc') }}</label>
        <input type="text" class="form-control" id="dieu-kien-query" name="sim_setting[query]"
            value="{{ $sim_setting['query'] ?? '' }}" autocomplete="off">
    </div>
    {!! $after !!}
</form>
