<tr>
    <td>
        {{ $tag->name }}
    </td>
    <td>
        @if ($tag->featured_image)
            <img class="rounded d-block" id="featured_image_thumbnail" width="80px" height="auto"
                src="{{ url("storage/{$tag->featured_image}") }}" alt="">
        @endif
    </td>
    <td>{{ $tag->slug }}</td>
    <td>{!! str(strip_tags($tag->description))->limit(150, '...') !!}</td>
    <td>{{ $tag->created_at->format('d/m/Y H:i') }}</td>
    <td>{{ $tag->updated_at->locale('vi')->diffForHumans() }}</td>
    <td>
        <form action="{{ route('admin.tag.restore',[$tag->id]) }}" method="post"
            onsubmit="javascript: return confirm('{{ __('Bạn có chắc chắn muốn khôi phục') }}')" class="d-inline ml-2">
            @csrf
            @method('put')
            <button type="submit" class="btn btn-sm btn-outline-warning"> {{ __('Khôi phục') }}</button>
        </form>
        <form action="{{ route('admin.tag.force-delete', [$tag->id]) }}" method="post"
            onsubmit="javascript: return confirm('{{ __('Bạn có chắc chắn muốn xóa vĩnh viễn bản ghi. Lưu ý bản ghi sẽ không thể khôi phục') }}')" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-outline-secondary">{{ __('Xóa') }}</button>
        </form>
    </td>
</tr>
