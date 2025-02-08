@extends('layouts.phong-thuy')

@section('content')
    <article class="page-category content-phongthuy">
        <div class="content-inner">
            <h1 class="st_title">Tìm Sim Phong Thủy</h1>
            <div class="phongthuy_wp">
                @include('components.theme.section.form-phong-thuy')
            </div>
            <div class="checkbox_submit_search_desktop view_sp mb-40">
                <x-theme.block.corner-block :items="\App\Enums\PhongThuyMenu::MENU_TOP"/>
            </div>
            @if($errors->any())
                <div class="article-note">Qúy khách vui lòng cung cấp đầy đủ thông tin ngày tháng năm sinh để tìm kiếm kết quả phù hợp nhất !.</div>
            @endif
            <div class="article-content">
                @if(!empty($content_data))
                    <div class="search-result">
                        <div id="box_pt_details" class="corner corner-top-left corner-red">
                            <div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        <div class="corner corner-bottom-left corner-red">
                            <div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        <div class="corner corner-top-right corner-red">
                            <div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        <div class="corner corner-bottom-right corner-red">
                            <div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        <div class="search-result__inner">
                            <img class="search-result__img lazy" src="{{ $content_data['menh_chu']['con_giap'] }}" alt="Sim thăng long 12 con giáp">
                            <ul>
                                <li>
                                    <strong>Thân chủ</strong>: {{ $content_data['menh_chu']['than_chu'] }}
                                </li>
                                <li>
                                    <strong>Năm Can Chi</strong>: {{ $content_data['menh_chu']['nam_can_chi'] }}
                                </li>
                                <li>
                                    <strong>Mệnh niên</strong>: {{ $content_data['menh_chu']['menh_nien'] }}
                                </li>
                                <li>
                                    <strong>Mệnh quái</strong>: {{ $content_data['menh_chu']['menh_quai'] }}
                                </li>
                                <li>
                                    <strong>Con Giáp</strong>: {{ $content_data['menh_chu']['cung_menh'] }}
                                </li>
                                <li>
                                    <strong>Bát tự</strong>: {!! $content_data['menh_chu']['bat_tu'] !!}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <x-theme.section.dynamic-content>
                        <p>{!! $content_data['tong_quan'] !!}</p>
                        <h2 class="pt-title">1. Tổng quan ưu, khuyết điểm của mệnh chủ</h2>
                        @foreach($content_data['luan_giai'] as $item)
                            <p>- {!! $item !!}</p>
                        @endforeach
                        <h2 class="pt-title">2. Sim cải mệnh cho người {{ $content_data['sim_cai_menh']['ban_menh'] }}</h2>
                        <div style="text-align: center">
                            <img src="/static/theme/images/phongthuy/sim-cai-menh.png" alt="Sim cải mệnh cho người {{ $content_data['sim_cai_menh']['ban_menh'] }}">
                        </div>
                        {!! $content_data['sim_cai_menh']['dang_so'] !!}
                        {!! $content_data['sim_cai_menh']['sim_ngu_hanh'] !!}
                        {!! $content_data['sim_cai_menh']['y_nghia_hop_menh'] !!}
                    </x-theme.section.dynamic-content>
                    <div id="result-sim" class="result-sim" style="overflow: unset">
                        <div class="pt-block-filter">
                            <div class="result-sim__header">
                                <h2 class="result-sim__title">Sim hợp tuổi {{ request()->get('gt')=='nu'?'Nữ':'Nam' }} {{ request()->get('ns').'/'.request()->get('ts').'/'.request()->get('ls') }}</h2>
                            </div>
                            <div class="category-filter">
                                <div class="scroll-x home-filter view_tab-sp">
                                    <div class="clearfix">
                                        @if($heads && count($heads ?? []) > 1)
                                            <x-theme.block.filters.filter-heads :$heads :$active_filter_items/>
                                        @else
                                            <div style="display: none" class="sim-card-item sim-card-net">
                                                <a href="javascript: toggleFilterWithLink('h','09', '/sim-dau-so-$item', 1)" title="Sim số đầu 09" role="button">09x</a>
                                            </div>
                                            <div style="display: none" class="sim-card-item sim-card-net">
                                                <a href="javascript: toggleFilterWithLink('h','08', '/sim-dau-so-$item', 1)" title="Sim số đầu 08" role="button">08x</a>
                                            </div>
                                        @endif
                                        @if(!$heads)
                                            <x-theme.block.filters.filter-tel :items="\App\Enums\SimType::FILTER_TEL" :$active_filter_items/>
                                        @endif
                                    </div>
                                </div>
                                <div class="scroll-x home-filter view_tab-sp pt-10 mb-10">
                                    <div class="clearfix">
                                        <x-theme.block.filters.filter-prices :items="\App\Enums\SimType::FILTER_PRICES" :$active_filter_items/>
                                    </div>
                                </div>
                                <x-theme.block.adv-filter-desktop :$active_filter_items :phong_thuy_query="$query ?? ''"/>
                            </div>
                        </div>
                        <div class="phongthuy-sim page-category">
                            <x-theme.section.table-sim-phongthuy :$mobile :data="$content_data['lists'] ?? []"/>
                        </div>
                        {!! $content_data['lists']->links('components.theme.block.pagination') !!}
                    </div>
                    <div class="result_pt">
                        {!! optional($seo_page)->content !!}
                    </div>
                    <div class="category-tag">
                        @for($i=2000; $i>=1970; $i--)
                            <a href="/sim-hop-tuoi-{{ $i }}">Sim hợp tuổi {{ $i }}</a>
                        @endfor
                    </div>
                @endif
            </div>
        </div>
    </article>
    <script>
        document.addEventListener('DOMContentLoaded', function (){
            const element = document.getElementById("result-sim");
            element.scrollIntoView();
        });
    </script>
@endsection
