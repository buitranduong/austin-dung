@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <table class="table table-striped table-hover mt-3">
            <thead class="table-light">
                <tr>
                    <th class="col-3">Thông tin đơn hàng</th>
                    <th class="col-9"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-bold">Mã đơn hàng:</td>
                    <td>{{ $simOrder->id }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Tạo lúc:</td>
                    <td>{{ $simOrder->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Nguồn đơn:</td>
                    <td>{{ $simOrder->source_text }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Loại đơn:</td>
                    <td>{{ __($simOrder->order_type->value) }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Push đơn:</td>
                    <td>
                        <form action="{{ route('admin.seller.order.rePush',[$simOrder->id]) }}" method="post" onsubmit="return confirm('Bạn muốn đẩy lại đơn?')">
                            @method('put')
                            @csrf
                            @if ($simOrder->pushed)
                                <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip">
                                    <i class="bi bi-check-circle-fill"></i>
                                </button>
                            @else
                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip">
                                    <i class="bi bi-x-circle-fill"></i>
                                </button>
                            @endif
                        </form>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Hình thức thanh toán:</td>
                    <td>{{ __($simOrder->payment_method->value) }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Thông tin trả góp:</td>
                    @if($simOrder->order_type->value == 'Installment')
                    <td>
                        Số tiền trả trước: {{format_money($simOrder->attributes['so_tien_tra_truoc'])}} <br>
                        Số tiền nợ: {{format_money($simOrder->attributes['so_tien_no'])}}<br>
                        Số tiền phải trả mỗi tháng: {{format_money($simOrder->attributes['so_tien_moi_thang'])}}<br>
                        Số phần trăm đã trả trước: {{$simOrder->attributes['tra_truoc']}}%<br>
                        Kỳ hạn: {{$simOrder->attributes['ky_han']}} tháng
                    </td>
                    @else
                    <td>
                        Giá gốc: {{format_money($simOrder->attributes['gia_goc'])}} <br>
                        Giá bán: {{format_money($simOrder->attributes['gia_ban'])}}
                    </td>
                    @endif
                </tr>
                <tr>
                    <td class="fw-bold">Lịch sử truy cập mua hàng:</td>
                    <td class="text-break">
                        @if(!empty($simOrder->browse_history))
                            <ul>
                                @foreach($simOrder->browse_history as $historyItem)
                                    <li>{{{ $historyItem }}}</li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">IP:</td>
                    <td>{{ __($simOrder->ip) }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Yêu cầu khác:</td>
                    <td>
                        <textarea id="other_option" name="other_option" class="form-control" style="height: 100px" disabled>{{ $simOrder->other_option }}</textarea>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table table-striped table-hover mt-4">
            <thead class="table-light">
                <tr>
                    <th class="col-3">Thông tin sim</th>
                    <th class="col-9"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-bold">Số sim đặt mua:</td>
                    <td>{{ $simOrder->sim }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Nhà mạng:</td>
                    <td>
                        @foreach ($listTel as $key => $tel)
                            @if ($tel['id'] == $simOrder->telco_id)
                                {{ $tel['name'] }}
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Giá bán:</td>
                    <td>{{ format_money($simOrder->amount) }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-striped table-hover mt-4">
            <thead class="table-light">
                <tr>
                    <th class="col-3">Thông tin khách hàng</th>
                    <th class="col-9"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-bold">Tên khách hàng:</td>
                    <td>{{ $simOrder->name }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Số điện thoại:</td>
                    <td>{{ \Illuminate\Support\Str::limit($simOrder->phone, 6,'****') }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Địa chỉ:</td>
                    <td>
                        <textarea id="address" name="address" class="form-control" style="height: 100px" disabled>{{ $simOrder->address }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Mã số thuế:</td>
                    <td>{{ $simOrder->mst }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
