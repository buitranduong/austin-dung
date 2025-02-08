@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="d-flex">
            <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                <div>
                    <a href="{{ route('admin.page.index') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                        </svg>
                        {{ __('Quay lại') }}
                    </a>
                </div>
                <div>
                    <select id="batchActionSelect" class="form-select" aria-label="{{ __('Hành động') }}">
                        <option value="" disabled selected>{{ __('Hành động') }}</option>
                        <option value="1">{{ __('Khôi phục') }}</option>
                        <option value="2">{{ __('Xóa vĩnh viễn') }}</option>
                    </select>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary" onclick="batchAction()">Thực hiện</button>
                </div>
            </div>
            <div class="d-inline-flex gap-1 align-items-center">
                <div>
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
                    <th scope="col" class="col">Ảnh</th>
                    <th scope="col" class="col">Tiêu đề</th>
                    <th scope="col" class="col">Ngày tạo</th>
                    <th scope="col" class="col">Cập nhật</th>
                    <th scope="col" class="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input batch-checkbox" type="checkbox" value="{{ $page->id }}"
                                    name="selected_pages[]">
                            </div>
                        </td>
                        <td>
                            @if ($page->featured_image)
                                <img class="rounded d-block" id="featured_image_thumbnail" width="80px" height="auto"
                                    src="{{ url("storage/{$page->featured_image}") }}" alt="">
                            @endif
                        </td>
                        <td>{{ $page->title }}</td>
                        <td>{{ $page->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $page->updated_at->locale('vi')->diffForHumans() }}</td>
                        <td>
                            <form action="{{ route('admin.page.restore', [$page->id]) }}" method="post"
                                onsubmit="javascript: return confirm('{{ __('Bạn có chắc chắn muốn khôi phục') }}')"
                                class="d-inline ml-2">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-sm btn-outline-warning">
                                    {{ __('Khôi phục') }}</button>
                            </form>
                            <form action="{{ route('admin.page.force-delete', [$page->id]) }}" method="post"
                                onsubmit="javascript: return confirm('{{ __('Bạn có chắc chắn muốn xóa vĩnh viễn bản ghi. Lưu ý bản ghi sẽ không thể khôi phục') }}')"
                                class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit"
                                    class="btn btn-sm btn-outline-secondary">{{ __('Xóa') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <caption>
                {{ $pages->links() }}
            </caption>
        </table>
    </div>
@endsection
@section('script')
    <script>
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
            if (action === '2') {
                confirmMessage = 'Bạn có chắc chắn muốn xóa vĩnh viễn các bài viết đã chọn?';
            } else if (action === '1') {
                confirmMessage = 'Bạn có chắc chắn muốn khôi phục các bài viết đã chọn?';
            }

            if (confirm(confirmMessage)) {
                sendBatchRequest(action, selectedPages);
            }
        }

        function sendBatchRequest(action, selectedPages) {
            let formData = new FormData();
            formData.append('action', action);
            formData.append('selected_pages', JSON.stringify(selectedPages));

            fetch("{{ route('admin.page.trash-batch-action') }}", {
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
