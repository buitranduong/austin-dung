<div class="sidebar-right">
    <div class="checkbox_submit_search_desktop view_pc-tab">
        <x-theme.block.corner-block :items="\App\Enums\PhongThuyMenu::MENU_TOP"/>
    </div>
    <x-theme.block.corner-block title="Sim hợp mệnh" :items="\App\Enums\PhongThuyMenu::MENU_SIM_HOP_MENH"/>
    <x-theme.block.corner-block title="Sim hợp tuổi" :items="\App\Enums\PhongThuyMenu::MENU_SIM_HOP_TUOI"/>
    <x-theme.block.corner-block title="Sim hợp năm sinh">
        @for($i=2000; $i>=1970; $i--)
            <a class="list-group-item lgit" href="/sim-hop-tuoi-{{ $i }}">Sim hợp tuổi {{ $i }}</a>
        @endfor
    </x-theme.block.corner-block>
</div>
