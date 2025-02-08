@props([
    'data'=>[],
    'link'=>'',
    'title'=>'',
    'mobile'=>false
])
<div class="wrapper-list-sim">
    <div id="list-sim" class="list-sim">
    @if($data)
        @foreach($data as $sim)
            <x-theme.block.sim-item :$sim />
        @endforeach
    @endif
    </div>
    @if($link)
    <div class="text-center mt-15">
        <a href="{{ $link }}" class="btn-read-more">{!! $title !!}</a>
    </div>
    @endif
</div>
@if($data && empty($link) && ($data->total() > 0 && $data->total() > $data->perPage()) && $data->lastPage() > (int)request()->get('p'))
    <div class="text-center mt-15 mb-15">
        <a href="{{ $data->nextPageUrl() }}" id="btn-read-more" class="btn-read-more">
            Xem tiếp <strong>{{ number_format($data->total() - $data->count() * $data->currentPage(), 0, '', '.') }}</strong> sim
        </a>
    </div>
    <div id="page_loader" style="display: none">
        <div class="logo"></div>
        <div class="loader"></div>
    </div>
@endif
