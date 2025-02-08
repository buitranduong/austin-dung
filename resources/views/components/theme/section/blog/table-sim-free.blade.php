@props([
    'title'=>''
])
<h2 class="title-dipsim">{{ $title }}</h2>
<div id="dip_pagesimtang" data-filter="t=&c=&&prices=&limit=15&utm_source_prevent=stlvn&link_sales={{ url('tang-sim') }}"></div>
<script src="https://sim.vn/js/dip_sim_v2.js" type="text/javascript"></script>
