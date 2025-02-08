<tr>
    <td>
        @if ($category->parent_id)
            --
        @endif
        <a data-bs-toggle="tooltip" data-bs-title="Sửa danh mục" href="{{ route('admin.category.edit', [$category->id]) }}"
            class="btn btn-link p-0 text-start">{{ $category->name }}</a>
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
        <form action="{{ route('admin.category.featured', [$category->id]) }}" method="post">
            @csrf
            @method('patch')
            @if ($category->featured)
                <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                    data-bs-title="Chuyển dừng hoạt động" @cannot('CategoryController.edit') disabled @endif>
                    <i class="bi bi-check-circle-fill"></i>
                </button>
                <input type="hidden" name="featured" value="0">
            @else
                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                    data-bs-title="Chuyển kích hoạt" @cannot('CategoryController.edit') disabled @endif>
                    <i class="bi bi-x-circle-fill"></i>
                </button>
                <input type="hidden" name="featured" value="1">
            @endif
        </form>
    </td>
    <td class="text-center">
        <form action="{{ route('admin.category.publish', [$category->id]) }}" method="post">
            @csrf
            @method('patch')
            @if ($category->published)
                <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                    data-bs-title="Chuyển dừng hoạt động" @cannot('CategoryController.edit') disabled @endif>
                    <i class="bi bi-check-circle-fill"></i>
                </button>
                <input type="hidden" name="published" value="0">
            @else
                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                    data-bs-title="Chuyển kích hoạt" @cannot('CategoryController.edit') disabled @endif>
                    <i class="bi bi-x-circle-fill"></i>
                </button>
                <input type="hidden" name="published" value="1">
            @endif
        </form>
    </td>
    <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
    <td>{{ $category->updated_at->locale('vi')->diffForHumans() }}</td>
    <td>
        @can('CategoryController.destroy')
        <form action="{{ route('admin.category.destroy', [$category->id]) }}" method="post"
            onsubmit="javascript: return confirm('{{ __('Bạn có chắc chắn muốn xóa') }}')">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-outline-secondary">{{ __('Xóa') }}</button>
        </form>
        @endif
    </td>
</tr>
@foreach ($category->children as $category)
    <x-admin.category.table :category="$category" />
@endforeach
