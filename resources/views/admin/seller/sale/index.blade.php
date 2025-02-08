@extends('layouts.admin')

@section('preload')
    <x-admin.modal-form class="custom-price" id="custom-price-create" title="Thêm mới tuỳ chỉnh giá"
        action="{{ route('admin.seller.sale.store') }}">
        <div class="mb-3">
            <div class="form-label">{{ __('Ưu tiên hiển thị theo Khoảng giá (vnđ)') }} <span class="text-danger">*</span>
            </div>
            <div class="input-group">
                <span class="input-group-text">{{ __('Từ') }}</span>
                <input id="price" inputmode="decimal" type="text"
                    class="form-control @error('price_from') is-invalid @enderror" name="price_from"
                    value="{{ old('price_from') }}">
                <span class="input-group-text"><i class="bi bi-arrow-right-short"></i> {{ __('Đến') }}</span>
                <input id="price" inputmode="decimal" type="text"
                    class="form-control @error('price_to') is-invalid @enderror" name="price_to"
                    value="{{ old('price_to') }}">
            </div>
            @error('price_from')
                <div class="error-message text-danger">{{ $message }}</div>
            @enderror
            @error('price_to')
                <div class="error-message text-danger">{{ $message }}</div>
            @enderror
            <div class="form-text mt-2 mb-3 fst-italic text-danger-emphasis">
                <p class="m-0">Giá bạn nhập phải là mức giá chính xác.</p>
                <p>VD: 1.000.000</p>
            </div>
        </div>
        <div class="mb-2">
            <label for="percent" class="form-label fw-bold mb-0">{{ __('Phần trăm điều chỉnh(<100%) ') }} <span
                    class="text-danger">*</span></label>
            <div class="input-group">
                <input type="number" id="percent" name="percent" class="form-control" value="{{ old('percent') }}">
                <span class="input-group-text">%</span>
            </div>
            @error('percent')
                <div class="error-message text-danger">{{ $message }}</div>
            @enderror
        </div>
    </x-admin.modal-form>
@endsection

@section('content')
    <div>
        <div class="d-flex">
            <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                <div>
                    @can('SaleController.store')
                    <a href="#custom-price-create" data-bs-toggle="modal" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                        </svg>
                        {{ __('Thêm mới') }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover mt-3">
            <thead class="table-light">
                <tr>
                    <th scope="col">Giá từ (VNĐ)</th>
                    <th scope="col">Giá đến (VNĐ)</th>
                    <th scope="col">Phần trăm</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($custom_prices as $custom)
                    <tr>
                        <td>{{ format_money($custom->price_from) }}</td>
                        <td>{{ format_money($custom->price_to) }}</td>
                        <td>{{ $custom->percent }} %</td>
                        <td>
                            <div class="d-flex d-flex-inline gap-2">
                                @can('SaleController.update')
                                <a href="#custom-price-create" data-bs-data="{{ json_encode($custom->toArray()) }}"
                                    data-bs-toggle="modal" data-bs-method="put"
                                    data-bs-action="{{ route('admin.seller.sale.update', [$custom->id]) }}"
                                    class="btn btn-sm btn-outline-warning">{{ __('Sửa') }}</a>
                                @endif
                                @can('SaleController.destroy')
                                <form action="{{ route('admin.seller.sale.destroy', [$custom->id]) }}" method="post"
                                    onsubmit="javascript: return confirm('{{ __('Thao tác không thể phục hồi, bạn chắc chắn muốn xóa?') }}');">
                                    @method('delete')
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm btn-outline-secondary">{{ __('Xóa') }}</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">{{ __('Không có bản ghi') }}</td>
                    </tr>
                @endforelse
            </tbody>
            <caption>
                {{ $custom_prices->links() }}
            </caption>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{ asset('static/js/jquery.inputmask.min.js') }}"></script>
    <script type="text/javascript">
        @if ($errors->any())
            $(window).on('load', function() {
                $('#custom-price-create').modal('show');
            });
        @endif
        const exampleModal = document.getElementById('custom-price-create')
        if (exampleModal) {
            exampleModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const method = button.getAttribute('data-bs-method');
                if (method === 'put') {
                    const modalForm = exampleModal.querySelector('form');
                    modalForm.action = button.getAttribute('data-bs-action');
                    const inputMethod = document.createElement('input');
                    inputMethod.type = "hidden";
                    inputMethod.name = "_method";
                    inputMethod.value = "PUT";
                    modalForm.appendChild(inputMethod);
                    const modalTitle = exampleModal.querySelector('.modal-title')
                    modalTitle.textContent = 'Sửa tuỳ chỉnh giá';

                    const data = JSON.parse(button.getAttribute('data-bs-data'));
                    modalForm.querySelector('input[name="price_from"]').value = data.price_from;
                    modalForm.querySelector('input[name="price_to"]').value = data.price_to;
                    modalForm.querySelector('input[name="percent"]').value = data.percent;
                }
            });
            exampleModal.addEventListener('hide.bs.modal', () => {
                const modalForm = exampleModal.querySelector('form');
                modalForm.reset();
                modalForm.action = "{{ route('admin.seller.sale.store') }}";
                const methodEl = modalForm.querySelector('input[name="_method"]');
                if(methodEl && typeof methodEl !== 'undefined'){
                    methodEl.remove();
                }
            });
        }
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
