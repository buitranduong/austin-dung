<tr>
    <td>
        <a data-bs-toggle="tooltip" data-bs-title="Sửa thẻ" href="{{ route('admin.tag.edit', [$tag->id]) }}" class="btn btn-link p-0 text-start">{{ $tag->name }}</a>
    </td>
    <td>
        @if ($tag->featured_image)
            <img class="rounded d-block" id="featured_image_thumbnail" width="80px" height="auto"
                src="{{ url("storage/{$tag->featured_image}") }}" alt="">
        @endif
    </td>
    <td>{{ $tag->slug }}</td>
    <td>{!! str(strip_tags($tag->description))->limit(150, '...') !!}</td>
    <td class="text-center">
        <form action="{{ route('admin.tag.featured', [$tag->id]) }}" method="post">
            @csrf
            @method('patch')
            @if ($tag->featured)
                <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                    data-bs-title="Chuyển dừng hoạt động" @cannot('TagController.edit') disabled @endif>
                    <i class="bi bi-check-circle-fill"></i>
                </button>
                <input type="hidden" name="featured" value="0">
            @else
                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                    data-bs-title="Chuyển kích hoạt" @cannot('TagController.edit') disabled @endif>
                    <i class="bi bi-x-circle-fill"></i>
                </button>
                <input type="hidden" name="featured" value="1">
            @endif
        </form>
    </td>
    <td>{{ $tag->created_at->format('d/m/Y H:i') }}</td>
    <td>{{ $tag->updated_at->locale('vi')->diffForHumans() }}</td>
    <td>
        @can('TagController.destroy')
        <form action="{{ route('admin.tag.destroy',[$tag->id]) }}" method="post" onsubmit="javascript: return confirm('{{ __('Bạn có chắc chắn muốn xóa') }}')">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-outline-secondary">{{ __('Xóa') }}</button>
        </form>
        @endif
    </td>
</tr>
