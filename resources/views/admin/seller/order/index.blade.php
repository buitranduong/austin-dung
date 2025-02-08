@extends('layouts.admin')

@section('preload')
    <x-admin.modal-form class="order-blacklist" id="order-blacklist" title="Danh sách chặn đặt hàng"
                        action="{{ route('admin.seller.order.setting') }}">
        <div class="mb-2">
            <label for="black_phone" class="form-label fw-bold mb-0">{{ __('Số điện thoại:') }}</label>
            <textarea id="black_phone" name="black_phone" class="form-control">{!! implode("&#13;&#10;", $order_setting->black_phone) !!}</textarea>
            <div class="form-text mt-2 mb-3 fst-italic text-danger-emphasis">
                <p>Lưu ý: Có thể nhập nhiều số, mỗi số cách nhau bởi một lần xuống dòng</p>
            </div>
            @error('black_phone')
            <div class="error-message text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-2">
            <label for="black_ip" class="form-label fw-bold mb-0">{{ __('Địa chỉ IP:') }}</label>
            <textarea id="black_ip" name="black_ip" class="form-control">{!! implode("&#13;&#10;", $order_setting->black_ip) !!}</textarea>
            <div class="form-text mt-2 mb-3 fst-italic text-danger-emphasis">
                <p class="m-0">Lưu ý: Có thể nhập nhiều IP, mỗi dãy IP cách nhau bởi một lần xuống dòng</p>
                <p>VD: 192.168.0.1 hoặc 192.168.0.*</p>
            </div>
            @error('black_ip')
            <div class="error-message text-danger">{{ $message }}</div>
            @enderror
        </div>
    </x-admin.modal-form>
@endsection

@section('content')
    <div>
        <div class="mb-3 d-flex">
            <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                <a href="#order-blacklist" data-bs-toggle="modal" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-fill-x" viewBox="0 0 16 16">
                        <path d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0M6.854 5.146 8 6.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 7l1.147 1.146a.5.5 0 0 1-.708.708L8 7.707 6.854 8.854a.5.5 0 1 1-.708-.708L7.293 7 6.146 5.854a.5.5 0 1 1 .708-.708"/>
                    </svg>
                    {{ __('Chặn đơn trêu') }}
                </a>
            </div>
            <div class="d-inline-flex gap-1 align-items-center">
                <div>
                    <label class="fs-5">{{ 'Lọc' }}: </label>
                </div>
                <div>
                    <select class="form-select" name="filter" id="filter" aria-label="Nhà mạng">
                        <option value="" selected>{{ 'Nhà mạng' }}</option>
                        @foreach ($listTel as $tel)
                            <option value="{{ $tel['id'] }}" @if (app('request')->input('filter') == $tel['id']) selected @endif>
                                {{ $tel['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select class="form-select" name="time" id="time" aria-label="Thời gian">
                        <option value="" selected>{{ 'Thời gian' }}</option>
                        <option value="7_days" @if (app('request')->input('time') == '7_days') selected @endif>{{ __('7 ngày gần nhất')}}</option>
                        <option value="2_weeks" @if (app('request')->input('time') == '2_weeks') selected @endif>{{ __('2 tuần gần nhất')}}</option>
                        <option value="3_weeks" @if (app('request')->input('time') == '3_weeks') selected @endif>{{ __('3 tuần gần nhất')}}</option>
                        <option value="1_month" @if (app('request')->input('time') == '1_month') selected @endif>{{ __('1 tháng gần nhất')}}</option>
                        <option value="3_month" @if (app('request')->input('time') == '3_month') selected @endif>{{ __('3 tháng gần nhất')}}</option>
                        <option value="1_year" @if (app('request')->input('time') == '1_year') selected @endif>{{ __('1 năm gần nhất')}}</option>
                    </select>
                </div>
                <div>
                    <select class="form-select" name="pushed" aria-label="{{ 'Trạng thái' }}" id="pushed">
                        <option value="" selected>{{ 'Trạng thái' }}</option>
                        <option value="true" @if (app('request')->input('pushed') == 'true') selected @endif>{{ 'Pushed' }}
                        </option>
                        <option value="false" @if (app('request')->input('pushed') == 'false') selected @endif>{{ 'Unpushed' }}
                        </option>
                    </select>
                </div>
                <div class="d-inline-flex gap-1 align-items-center">
                    <form action="" method="get" id="search-form">
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="bi bi-search"></i>
                        </span>
                            <input name="q" value="{{ app('request')->get('q') }}" type="text" class="form-control"
                                   placeholder="Từ khóa ..." aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover mt-3">
            <thead class="table-light">
                <tr>
                    <th scope="col">Sim đặt mua</th>
                    <th scope="col">Giá bán</th>
                    <th scope="col">Nhà mạng</th>
                    <th scope="col">Tên KH</th>
                    <th scope="col">Địa chỉ KH</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">Cập nhật</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($simOrders as $simOrder)
                    <tr>
                        <td><a data-bs-toggle="tooltip" data-bs-title="Chi tiết đơn hàng"
                            href="{{ route('admin.seller.order.detail', [$simOrder->id]) }}"
                                class="btn btn-link p-0">{{ $simOrder->sim }}</a>
                        </td>
                        <td>{{  format_money($simOrder->amount) }}</td>
                        @foreach ($listTel as $key => $tel)
                            @if ($tel['id'] == $simOrder->telco_id)
                                <td>{{ $tel['name'] }}</td>
                            @endif
                        @endforeach
                        <td>{{ $simOrder->name }}</td>
                        <td>{{ $simOrder->address }}</td>
                        <td class="text-center">
                            @if ($simOrder->pushed)
                                <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip">
                                    <i class="bi bi-check-circle-fill"></i>
                                </button>
                            @else
                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip">
                                    <i class="bi bi-x-circle-fill"></i>
                                </button>
                            @endif
                        </td>
                        <td>{{ $simOrder->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $simOrder->updated_at->locale('vi')->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
            <caption>
                {{ $simOrders->withQueryString()->links() }}
            </caption>
        </table>
    </div>
@endsection
@section('script')
    <script>
        function redirectToIndex() {
            var searchValue = document.querySelector('input[name="q"]').value;
            var filterValue = document.querySelector('select[name="filter"]').value;
            var pushedValue = document.querySelector('select[name="pushed"]').value;
            var time = document.querySelector('select[name="time"]').value;
            window.location.href = "{{ route('admin.seller.order.index') }}?q=" + searchValue + "&filter=" +
                filterValue + "&pushed=" + pushedValue + "&time=" + time;
        }

        document.getElementById('search-form').addEventListener('submit', function(event) {
            event.preventDefault();
            redirectToIndex();
        });

        document.getElementById('filter').addEventListener('change', function() {
            redirectToIndex();
        });

        document.getElementById('pushed').addEventListener('change', function() {
            redirectToIndex();
        });
        document.getElementById('time').addEventListener('change', function() {
            redirectToIndex();
        });
    </script>
@endsection
