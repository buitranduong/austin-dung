<tr>
    <td>
        @if ($category->parent_id)
            --
        @endif
        {{ $category->name }}
    </td>
    <td>
        @if ($category->featured_image)
            <img class="rounded d-block" id="featured_image_thumbnail" width="80px" height="auto"
                src="{{ url("storage/{$category->featured_image}") }}" alt="">
        @endif
    </td>
    <td>{{ $category->slug }}</td>
    <td>{!! str(strip_tags($category->description))->limit(150, '...') !!}</td>
    <td class="text-center">
        <form action="{{ route('admin.category.publish', [$category->id]) }}" method="post">
            @csrf
            @method('patch')
            @if ($category->published)
                <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                    data-bs-title="Chuyển dừng hoạt động">
                    <i class="bi bi-check-circle-fill"></i>
                </button>
                <input type="hidden" name="published" value="0">
            @else
                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                    data-bs-title="Chuyển kích hoạt">
                    <i class="bi bi-x-circle-fill"></i>
                </button>
                <input type="hidden" name="published" value="1">
            @endif
        </form>
    </td>
    <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
    <td>{{ $category->updated_at->locale('vi')->diffForHumans() }}</td>
    <td>
        <form action="{{ route('admin.category.restore', [$category->id]) }}" method="post"
            onsubmit="javascript: return confirm('{{ __('Bạn có chắc chắn muốn khôi phục') }}')" class="d-inline ml-2">
            @csrf
            @method('put')
            <button type="submit" class="btn btn-sm btn-outline-warning"> {{ __('Khôi phục') }}</button>
        </form>
        <form action="{{ route('admin.category.force-delete', [$category->id]) }}" method="post"
            onsubmit="javascript: return confirm('{{ __('Bạn có chắc chắn muốn xóa vĩnh viễn bản ghi. Lưu ý bản ghi sẽ không thể khôi phục') }}')" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-outline-secondary">{{ __('Xóa') }}</button>
        </form>
    </td>
</tr>
@foreach ($category->children as $category)
    <x-admin.category.table :category="$category" />
@endforeach
