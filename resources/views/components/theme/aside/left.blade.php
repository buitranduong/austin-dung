@props([
    'mobile'=>true
])
<aside class="sidebar-left view_pc" id="sidebar-left">
    <x-theme.aside.sidebar.sidebar-prices title="Sim theo giá" :items="\App\Enums\SimType::FILTER_PRICES"/>
    <x-theme.aside.sidebar.left title="Sim theo mạng" :items="\App\Enums\SimType::FILTER_TEL"/>
    <x-theme.aside.sidebar.left title="Sim theo loại" :items="\App\Enums\SimType::FILTER_CATES"/>
    <x-theme.aside.sidebar.left title="Sim năm sinh" :items="\App\Enums\SimType::FILTER_YEAR"/>
    @if(!$mobile) 
        <x-theme.aside.sidebar.popup-prices-range />
    @endif
</aside>
