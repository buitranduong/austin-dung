@extends('layouts.admin')

@section('content')
    <div>
        <form action="{{ route('admin.seller.warehouse.update') }}" method="POST" autocomplete="off">
            @csrf
            @can('WarehouseController.update')
            <div class="d-flex mb-3 pb-3 border-bottom">
                <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                        </svg>
                        {{ __('Lưu') }}
                    </button>
                </div>
            </div>
            @endif
            <fieldset>
                <legend>{{ __('Cài Đặt Kho Số') }}:</legend>
                <span>Áp dụng cho toàn website</span>
                <div class="mt-3 mb-3">
                    <label for="sim_update_lt_days" class="form-label fw-bold">{{ __('Lọc SIM cập nhật nhỏ hơn(ngày)') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-sd-card"></i></span>
                        <input type="number" class="form-control" id="sim_update_lt_days" name="sim_update_lt_days" value="{{ $warehouse_setting->sim_update_lt_days }}" @cannot('WarehouseController.update') disabled @endif>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="card">
                        <div class="card-header fw-bold">
                            {{ __('Ưu tiên hiển thị') }}
                        </div>
                        <div class="card-body">
                            <div class="card-title">
                                <div class="form-check">
                                    <input @if($warehouse_setting->is_only_warehouse) checked @endif class="form-check-input" type="checkbox" name="is_only_warehouse" value="1" id="is_only_warehouse" @cannot('WarehouseController.update') disabled @endif>
                                    <label class="form-check-label fw-bold" for="is_only_warehouse">
                                        {{ __('Chỉ bán trên những kho này') }}
                                    </label>
                                </div>
                            </div>
                            <div class="card-text">
                                <label for="priority_warehouse" class="form-label">{{ __('Nhập ID của đại lý muốn ưu tiên hiển thị') }}</label>
                                <textarea placeholder="ID 1&#10;ID 2" aria-describedby="priority_warehouse_help" class="form-control" name="priority_warehouse" id="priority_warehouse" @cannot('WarehouseController.update') disabled @endif>{!! implode("&#13;&#10;", $warehouse_setting->priority_warehouse) !!}</textarea>
                                <div id="priority_warehouse_help" class="form-text fst-italic text-danger-emphasis">(Có thể nhập nhiều ID, mỗi ID cách nhau bởi một lần xuống dòng)</div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header fw-bold">
                            {{ __('Ẩn hiển thị kho') }}
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <label for="ignores_warehouse" class="form-label">{{ __('Nhập ID của đại lý muốn ẩn hiển thị') }}</label>
                                <textarea placeholder="ID 1&#10;ID 2" aria-describedby="ignores_warehouse_help" class="form-control" name="ignores_warehouse" id="ignores_warehouse" @cannot('WarehouseController.update') disabled @endif>{!! implode("&#13;&#10;", $warehouse_setting->ignores_warehouse) !!}</textarea>
                                <div id="ignores_warehouse_help" class="form-text fst-italic text-danger-emphasis">(Có thể nhập nhiều ID, mỗi ID cách nhau bởi một lần xuống dòng)</div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header fw-bold">
                            {{ __('Ẩn Số Trên Web') }}
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <textarea placeholder="ID 1&#10;ID 2" aria-describedby="sim_hidden_help" class="form-control" name="sim_hidden" id="sim_hidden" @cannot('WarehouseController.update') disabled @endif>{!! implode("&#13;&#10;", $warehouse_setting->sim_hidden) !!}</textarea>
                                <div id="sim_hidden_help" class="form-text fst-italic text-danger-emphasis">Lưu ý: Mỗi số muốn ẩn tương ứng với một dòng</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div aria-describedby="sim_providers_help" class="form-label fw-bold mb-0">{{ __('Tuỳ chỉnh tỉ lệ hiển thị danh sách sim chung theo Nhà mạng') }}</div>
                    <div id="sim_providers_help" class="form-text mb-3 fst-italic text-danger-emphasis">Tổng tỉ lệ: 100%</div>
                    @foreach($sim_providers as $name)
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width: 80px;overflow: hidden">
                                @php($brand = \App\Enums\SimProviders::tryFrom($name)->brand())
                                <img src="{{ asset("static/images/{$brand}") }}" alt="">
                            </span>
                            <input type="number" class="form-control @error('percent_rates') is-invalid @enderror" name="percent_rates[{{ $name }}]" value="{{ optional($warehouse_setting->percent_rates)[$name] }}" @cannot('WarehouseController.update') disabled @endif>
                        </div>
                    @endforeach
                    @error('percent_rates')
                    <div class="form-text fw-bold text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <div aria-describedby="sim_providers_help" class="form-label fw-bold mb-0">{{ __('Tuỳ chỉnh tỉ lệ hiển thị danh sách "Tìm sim" theo Nhà mạng') }}</div>
                    <div id="sim_providers_help" class="form-text mb-3 fst-italic text-danger-emphasis">Tổng tỉ lệ: 100%</div>
                    @foreach($sim_providers as $name)
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="width: 80px;overflow: hidden">
                                @php($brand = \App\Enums\SimProviders::tryFrom($name)->brand())
                                <img src="{{ asset("static/images/{$brand}") }}" alt="">
                            </span>
                            <input type="number" class="form-control @error('filter_percent_rates') is-invalid @enderror" name="filter_percent_rates[{{ $name }}]" value="{{ optional($warehouse_setting->filter_percent_rates)[$name] }}" @cannot('WarehouseController.update') disabled @endif>
                        </div>
                    @endforeach
                    @error('percent_rates')
                    <div class="form-text fw-bold text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <div class="form-label fw-bold mb-0">{{ __('Ưu tiên hiển thị theo Khoảng giá (vnđ)') }}</div>
                    <div class="input-group">
                        <span class="input-group-text">{{ __('Từ') }}</span>
                        <input inputmode="decimal" maxlength="13" type="text" class="form-control @error('priority_price_min') is-invalid @enderror" name="priority_price_min" value="{{ $warehouse_setting->priority_price_min }}" @cannot('WarehouseController.update') disabled @endif>
                        <span class="input-group-text"><i class="bi bi-arrow-right-short"></i> {{ __('Đến') }}</span>
                        <input inputmode="decimal" maxlength="14" type="text" class="form-control @error('priority_price_max') is-invalid @enderror" name="priority_price_max" value="{{ $warehouse_setting->priority_price_max }}" @cannot('WarehouseController.update') disabled @endif>
                    </div>
                    @error('priority_price_min')
                    <div class="error-message text-danger">{{ $message }}</div>
                    @enderror
                    @error('priority_price_max')
                    <span class="error-message text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="sort_default" class="form-label fw-bold mb-0">{{ __('Tuỳ chỉnh hiển thị Sắp xếp') }}</label>
                    <div id="sort_default_help" class="form-text mb-3 fst-italic text-danger-emphasis">Nếu áp dụng sắp xếp tăng giảm, thì các thành phần ưu tiên sẽ không được áp dụng</div>
                    <select id="sort_default" aria-describedby="sort_default_help" name="sort_default" class="form-select" aria-label="Small select example" @cannot('WarehouseController.update') disabled @endif>
                        @foreach($sim_sort_default as $value=>$label)
                            <option value="{{ $value }}" @if($warehouse_setting->sort_default == $value) selected @endif>{{ __($label) }}</option>
                        @endforeach
                    </select>
                </div>
            </fieldset>
            @can('WarehouseController.update')
            <div class="d-flex mt-3 pt-3 border-top">
                <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                        </svg>
                        {{ __('Lưu') }}
                    </button>
                </div>
            </div>
            @endif
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('static/js/jquery.inputmask.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $("input[inputmode=\"decimal\"]").inputmask("decimal", {
                rightAlign: false,
                groupSeparator: ',',
                radixPoint: '.',
                removeMaskOnSubmit: true
            });
        });
    </script>
@endsection
