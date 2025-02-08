@extends('layouts.theme')

@section('content')
    <section class="list-sim-desc">
        <h1>{{ optional($seo_page)->title ?? 'SIM số đẹp' }}</h1>
        <div class="text-desc view_pc">
            @if(optional($seo_page)->excerpt)
                {!! $seo_page->excerpt !!}
            @else
                <strong>Sim so dep</strong> giá rẻ các mạng Viettel, Mobi, Vina. Bán Sim số đẹp giá gốc,
                đăng ký thông tin chính chủ. Giao <i>sim số đẹp</i> miễn phí Toàn Quốc.
            @endif
        </div>
        <div class="scroll-x home-filter view_tab-sp">
            <div class="clearfix">
                <x-theme.block.filters.filter-tel :items="\App\Enums\SimType::FILTER_TEL" :is_button="false"/>
            </div>
            <div class="clearfix">
                <x-theme.block.filters.filter-prices :items="\App\Enums\SimType::FILTER_PRICES" :is_button="false"/>
            </div>
            <div class="clearfix">
                <x-theme.block.filters.filter-cates :items="\App\Enums\SimType::FILTER_CATES" :is_button="false"/>
            </div>
        </div>
    </section>
    <!-- Block Viettel -->
    @if(!empty($home_sim_block['block']['viettel']))
        <x-theme.block.sim-block-list :data="$home_sim_block['block']['viettel']['listSim']" title="Sim Viettel" link="/sim-viettel" />
    @endif
    <!-- Block Khuyen mai -->
    @if(!empty($home_sim_block['block']['promotion']))
        <x-theme.block.sim-block-list :data="$home_sim_block['block']['promotion']['listSim']" title="Sim khuyến mãi" className="title-sale" subTitle="trong ngày" link="/sim-khuyen-mai" />
    @endif
    <!-- Block Tra gop -->
    @if(!empty($home_sim_block['block']['installment']))
        <x-theme.block.sim-block-list :data="$home_sim_block['block']['installment']['listSim']" title="Sim Trả Góp" link="/sim-dep-tra-gop" />
    @endif
    <!-- Block Vinaphone -->
    @if(!empty($home_sim_block['block']['vinaphone']))
        <x-theme.block.sim-block-list :data="$home_sim_block['block']['vinaphone']['listSim']" title="Sim Vinaphone" link="/sim-so-dep-vinaphone" />
    @endif
    <!-- Block Mobifone -->
    @if(!empty($home_sim_block['block']['mobifone']))
        <x-theme.block.sim-block-list :data="$home_sim_block['block']['mobifone']['listSim']" title="Sim Mobifone" link="/sim-so-dep-mobifone" />
    @endif
    @if(!empty($seo_page->content))
        <x-theme.section.dynamic-content>
            {!! html_entity_decode($seo_page->content) !!}
        </x-theme.section.dynamic-content>
    @endif
    <x-theme.section.faq-content :faq="optional($seo_page)->faq"/>
@endsection
