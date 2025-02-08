@extends('layouts.admin')
@section('content')
    <div>
        <div class="d-flex">
            <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                <div>
                    <select id="batchActionSelect" class="form-select" aria-label="{{ __('Hành động') }}">
                        <option value="" disabled selected>{{ __('Hành động') }}</option>
                        @can('PageController.edit')
                        <option value="1">{{ __('Dừng hiển thị/ẩn') }}</option>
                        @endif
                        @can('PageController.edit')
                        <option value="2" @cannot('PageController.edit') hidden @endif>{{ __('Hiển thị') }}</option>
                        @endif
                        @can('PageController.destroy')
                        <option value="3">{{ __('Chuyển vào thùng rác') }}</option>
                        @endif
                    </select>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary" onclick="batchAction()">Thực hiện</button>
                </div>
                <div class="">
                    <a href="{{ route('admin.page.create') }}"><button class="btn btn-success"  @cannot('PageController.create') hidden @endif>Thêm trang</button></a>
                </div>
                <div>
                    <a href="{{ route('admin.page.trash') }}" class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-trash" viewBox="0 0 16 16">
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                            <path
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                        </svg>
                        {{ __('Thùng rác') }}
                    </a>
                </div>
            </div>
            <div class="d-inline-flex gap-1 align-items-center">
                <div class="d-inline-flex gap-1 align-items-center">
                    <form action="" method="get">
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
        <table class="table table-striped table-hover mt-4">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('Ảnh') }}</th>
                    <th scope="col">{{ __('Tiêu đề') }}</th>
                    <th scope="col">{{ __('Trạng thái') }}</th>
                    <th scope="col"class="sort" data-sort="created_at" data-direction="{{ request('sort') == 'created_at' && request('direction') == 'desc' ? 'asc' : 'desc' }}" style="cursor: pointer;">{{ __('Thời gian') }}
                        @if(request('sort') == 'created_at')
                            @if(request('direction') == 'asc')
                                <i class="bi bi-caret-down-fill"></i>
                            @else
                                <i class="bi bi-caret-up-fill"></i>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="col">{{__('Cập nhật')}}</th>
                    <th scope="col">{{__('Thao tác')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <th scope="row">
                            <div class="form-check">
                                <input class="form-check-input batch-checkbox" type="checkbox" value="{{ $page->id }}"
                                    name="selected_pages[]">
                            </div>
                        </th>
                        <td>
                            @if ($page->featured_image)
                                <img class="rounded d-block" id="featured_image_thumbnail" width="80px" height="auto"
                                    src="{{ url("storage/{$page->featured_image}") }}" alt="">
                            @endif
                        </td>
                        <td>{{ $page->title }}</td>
                        <td>
                            @if ($page->status->value == 'published')
                                <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                                data-bs-title="{{__($page->status->name)}}">
                                <i class="bi bi-check-circle-fill"></i>
                                </button>

                            @else
                                    <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="{{__($page->status->name)}}">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </button>
                            @endif
                    </td>
                    <td>{{ $page->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $page->updated_at->locale('vi')->diffForHumans() }}</td>
                        <td>
                            <div class="col-3 d-flex gap-2">
                                <a href="{{ route('admin.page.edit', $page->id) }}"><button
                                        class="btn btn-sm btn-outline-warning">Sửa</button></a>
                                @can('PageController.destroy')
                                <form action="{{ route('admin.page.destroy', $page->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-secondary" type="submit"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa thẻ này không?')">Xóa</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <caption>
                {{ $pages->withQueryString()->links() }}
            </caption>
        </table>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.sort').click(function(event) {
                event.preventDefault();
                let sortField = $(this).data('sort');
                let sortDirection = $(this).data('direction');
                let url = new URL(window.location.href);
                let params = new URLSearchParams(url.search);
                params.set('sort', sortField);
                params.set('direction', sortDirection);
                url.search = params.toString();
                window.history.replaceState({}, '', url.toString());

                // Tải lại trang để áp dụng các thay đổi
                window.location.reload();
            });
        });

        function batchAction() {
            let action = document.getElementById('batchActionSelect').value;
            if (action === '') {
                alert('Vui lòng chọn một hành động.');
                return;
            }

            let selectedPages = [];
            document.querySelectorAll('.batch-checkbox:checked').forEach((checkbox) => {
                selectedPages.push(checkbox.value);
            });

            if (selectedPages.length === 0) {
                alert('Vui lòng chọn ít nhất một bài viết.');
                return;
            }
            let confirmMessage = '';
            if (action === '3') {
                confirmMessage = 'Bạn có chắc chắn muốn xóa các bài viết đã chọn?';
            } else if (action === '2') {
                confirmMessage = 'Bạn có chắc chắn muốn hiển thị các bài viết đã chọn?';
            } else if (action === '1') {
                confirmMessage = 'Bạn có chắc chắn muốn dừng hiển thị, ẩn các bài viết đã chọn?';
            }

            if (confirm(confirmMessage)) {
                sendBatchRequest(action, selectedPages);
            }
        }

        function sendBatchRequest(action, selectedPages) {
            let formData = new FormData();
            formData.append('action', action);
            formData.append('selected_pages', JSON.stringify(selectedPages));

            fetch("{{ route('admin.page.batch-action') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success)
                        window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

    </script>
@endsection
