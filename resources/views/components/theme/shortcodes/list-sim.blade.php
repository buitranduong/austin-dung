<div class="page-category">
    @if(!$mobile)
        <x-theme.section.table-sim :data="$sim_data ?? []" :$keyword/>
    @else
        <x-theme.section.list-sim :data="$sim_data ?? []" :$mobile/>
    @endif
</div>
