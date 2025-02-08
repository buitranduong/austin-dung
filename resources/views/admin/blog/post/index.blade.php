@extends('layouts.admin')
@section('content')
    <div>
        <div class="d-flex">
            <div class="d-inline-flex gap-1 flex-grow-1 align-items-center">
                <div>
                    <select id="batchActionSelect" class="form-select" aria-label="{{ __('Hành động') }}">
                        <option value="" disabled selected>{{ __('Hành động') }}</option>
                        @can('PostController.edit')
                        <option value="1">{{ __('Dừng hiển thị/ẩn') }}</option>
                        @endif
                        @can('PostController.edit')
                        <option value="2" @cannot('PostController.edit') hidden @endif>{{ __('Hiển thị') }}</option>
                        @endif
                        @can('PostController.destroy')
                        <option value="3"  @cannot('PostController.destroy') hidden @endif>{{ __('Chuyển vào thùng rác') }}</option>
                        @endif
                    </select>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary" onclick="batchAction()">Thực hiện</button>
                </div>
                <div class="">
                    @can('PostController.create')
                    <a href="{{ route('admin.post.create') }}"><button class="btn btn-success">Thêm bài viết</button></a>
                    @endif
                </div>
                <div>
                    <a href="{{ route('admin.post.trash') }}" class="btn btn-danger">
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
                <div>
                    <label class="fs-5">{{ __('Lọc') }}: </label>
                </div>
                <div>
                    <select class="form-select" name="category" aria-label="{{ __('Chuyên mục') }}">
                        <option value="" selected>{{ __('Chuyên mục') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>{{ __($category->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select class="form-select" name="status" aria-label="{{ __('Trạng thái') }}">
                        <option value="" selected>{{ __('Trạng thái') }}</option>
                        @foreach ($status as $key => $sta)
                            <option value="{{ $key}}"
                                {{ request('status') == $key ? 'selected' : '' }}>{{ __($sta) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="d-inline-flex gap-1 align-items-center">
                    <form action="" method="get">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-search"></i>
                            </span>
                            <input name="q" value="{{ app('request')->get('q') }}" type="text"
                                class="form-control" placeholder="Từ khóa ..." aria-label="Username"
                                aria-describedby="basic-addon1">
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
                    <th scope="col">{{ __('Chuyên mục') }}</th>
                    <th scope="col" class="col-3">{{ __('Thẻ') }}</th>
                    <th scope="col" class="text-center">{{ __('Trạng thái') }}</th>
                    <th scope="col"class="sort" data-sort="created_at" data-direction="{{ request('sort') == 'created_at' && request('direction') == 'desc' ? 'asc' : 'desc' }}" style="cursor: pointer;">{{ __('Thời gian') }}
                        @if(request('sort') == 'created_at')
                            @if(request('direction') == 'asc')
                                <i class="bi bi-caret-down-fill"></i>
                            @else
                                <i class="bi bi-caret-up-fill"></i>
                            @endif
                        @endif
                    </th>
                    <th scope="col">{{__('Thao tác')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <th scope="row">
                            <div class="form-check">
                                <input class="form-check-input batch-checkbox" type="checkbox" value="{{ $post->id }}"
                                    name="selected_posts[]">
                            </div>
                        </th>
                        <td>
                            @if ($post->featured_image)
                                <img class="rounded d-block" id="featured_image_thumbnail" width="80px" height="auto"
                                    src="{{ url("storage/{$post->featured_image}") }}" alt="">
                            @endif
                        </td>
                        <td>{{ $post->title }}</td>
                        <td>
                            @if ($post->categories->count())
                                {{ $post->categories->first()->name }}
                            @endif
                        </td>
                        <td>
                            @php
                                if ($post->tags->count()) {
                                    $tags = $post->tags;
                                    // Tạo một mảng chứa tên của các tag
                                    $tagNames = $tags->pluck('name')->toArray();
                                    // In ra các tên tag, ngăn cách bằng dấu phẩy
                                    echo implode(', ', $tagNames);
                                } else {
                                    echo 'Không có thẻ cho bài viết';
                                }
                            @endphp
                        </td>
                            <td class="text-center">
                                    @if ($post->status->value == 'published')
                                        <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="{{__($post->status->name)}}">
                                        <i class="bi bi-check-circle-fill"></i>
                                        </button>
                                    @else
                                            <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                                data-bs-title="{{__($post->status->name)}}">
                                                <i class="bi bi-x-circle-fill"></i>
                                            </button>
                                    @endif
                            </td>
                            <td scope="col">{{ $post->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="col-3 d-flex gap-2">
                                <a href="{{ route('admin.post.edit', $post->id) }}" class="btn btn-sm btn-outline-warning">Sửa</a>
                                @can('PostController.destroy')
                                <form action="{{ route('admin.post.destroy', $post->id) }}" method="post">
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
                {{ $posts->withQueryString()->links() }}
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

            let selectedPosts = [];
            document.querySelectorAll('.batch-checkbox:checked').forEach((checkbox) => {
                selectedPosts.push(checkbox.value);
            });

            if (selectedPosts.length === 0) {
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
                sendBatchRequest(action, selectedPosts);
            }
        }

        function sendBatchRequest(action, selectedPosts) {
            let formData = new FormData();
            formData.append('action', action);
            formData.append('selected_posts', JSON.stringify(selectedPosts));

            fetch("{{ route('admin.post.batch-action') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload(); // Reload trang sau khi xóa thành công
                    } else {
                        alert('Có lỗi xảy ra.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        $(document).ready(function() {
            // Xử lý sự kiện thay đổi giá trị của dropdown
            $('select[name="category"]').change(function() {
                updateQueryString();
            });
            $('select[name="status"]').change(function() {
                updateQueryString();
            });
            // Xử lý sự kiện nhấp chuột vào liên kết sắp xếp
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

            function updateQueryString() {
                let categoryValue = $('select[name="category"]').val();
                let statusValue = $('select[name="status"]').val();
                let searchValue = $('input[name="q"]').val();

                let url = new URL(window.location.href);
                let params = new URLSearchParams(url.search);

                if (categoryValue !== '') {
                    params.set('category', categoryValue);
                } else {
                    params.delete('category');
                }

                if (statusValue !== '') {
                    params.set('status', statusValue);
                } else {
                    params.delete('status');
                }

                if (searchValue !== '') {
                    params.set('q', searchValue);
                } else {
                    params.delete('q');
                }
                params.delete('page');
                url.search = params.toString();
                window.history.replaceState({}, '', url.toString());

                // Tải lại trang để áp dụng các thay đổi
                window.location.reload();
            }
        });
    </script>
@endsection
