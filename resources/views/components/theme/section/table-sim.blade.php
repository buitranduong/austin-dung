@props([
    'data'=>[],
    'keyword'=>'',
])
@if($data && method_exists($data, 'total') && $data->total())
<table class="tbl-category-pc">
    <thead class="view_pc view_tab-sp">
    <tr>
        <th>STT</th>
        <th>Số Sim</th>
        <th>Giá bán</th>
        <th>Mạng di động</th>
        <th>Loại sim</th>
        <th>Chi tiết</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $i=>$sim)
        <x-theme.block.sim-item :$i as="tr" :$sim/>
    @endforeach
    </tbody>
</table>
{!! $data->links('components.theme.block.pagination') !!}
@endif
