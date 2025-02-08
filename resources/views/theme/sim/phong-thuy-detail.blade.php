@extends('layouts.phong-thuy')

@section('content')
    <article class="content-phongthuy">
        <section class="content-inner">
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
            @if(!empty($content_data['menh_chu']))
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
                                <strong>{{ $content_data['menh_chu']['than_chu']['title'] }}</strong>: {{ $content_data['menh_chu']['than_chu']['text'] }}
                            </li>
                            <li>
                                <strong>{{ $content_data['menh_chu']['nam_can_chi']['title'] }}</strong>: {{ $content_data['menh_chu']['nam_can_chi']['text'] }}
                            </li>
                            <li>
                                <strong>{{ $content_data['menh_chu']['menh_nien']['title'] }}</strong>: {{ $content_data['menh_chu']['menh_nien']['text'] }}
                            </li>
                            <li>
                                <strong>{{ $content_data['menh_chu']['menh_quai']['title'] }}</strong>: {{ $content_data['menh_chu']['menh_quai']['text'] }}
                            </li>
                            <li>
                                <strong>{{ $content_data['menh_chu']['thai_nguyen']['title'] }}</strong>: {{ $content_data['menh_chu']['thai_nguyen']['text'] }}
                            </li>
                            <li>
                                <strong>{{ $content_data['menh_chu']['cung_menh']['title'] }}</strong>: {{ $content_data['menh_chu']['cung_menh']['text'] }}
                            </li>
                            <li>
                                <strong>{{ $content_data['menh_chu']['bat_tu']['title'] }}</strong>: {{ $content_data['menh_chu']['bat_tu']['text'] }}
                            </li>
                        </ul>
                    </div>
                </div>
                <section class="phongthuy-details">
                    <div class="phongthuy-details__inner">
                        <h2 class="ptm-title">{{ $content_data['luan_giai']['title'] ?? '' }}:</h2>
                        <div class="gioithieu">
                            {!! \Illuminate\Support\Arr::join($content_data['luan_giai']['top'], '') !!}
                        </div>
                        <hr>
                        <div class="groupbox">
                            <div class="title_result">{{ $content_data['luan_giai']['menh_chu']['title'] ?? '' }}</div>
                            <div class="box1_re">
                                {!! \Illuminate\Support\Arr::join($content_data['luan_giai']['menh_chu']['text'], '') !!}
                            </div>
                        </div>
                        <div class="groupbox">
                            <div class="title_result">{{ $content_data['luan_giai']['sinh_khi']['title'] ?? '' }}</div>
                            <div class="box1">
                                {!! \Illuminate\Support\Arr::join($content_data['luan_giai']['sinh_khi']['text'], '') !!}
                            </div>
                        </div>
                        <div class="groupbox">
                            <div class="title_result">{{ $content_data['luan_giai']['du_nien']['title'] ?? '' }}</div>
                            <div class="box1">
                                {!! \Illuminate\Support\Arr::join($content_data['luan_giai']['du_nien']['text'], '') !!}
                            </div>
                        </div>
                        <div class="groupbox">
                            <div class="title_result">{{ $content_data['luan_giai']['am_duong']['title'] ?? '' }}</div>
                            <div class="box1">
                                {!! \Illuminate\Support\Arr::join($content_data['luan_giai']['am_duong']['top'], '') !!}
                            </div>
                            <div class="box1_re">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            @foreach($content_data['luan_giai']['am_duong']['number'] as $item)
                                                <td>{{ $item['number'] }}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach($content_data['luan_giai']['am_duong']['number'] as $item)
                                                <td>{{ $item['text'] }}</td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clear"></div>
                                {!! \Illuminate\Support\Arr::join($content_data['luan_giai']['am_duong']['text'],'') !!}
                            </div>
                        </div>
                        <div class="groupbox">
                            <div class="title_result">{{ $content_data['luan_giai']['ngu_hanh']['title'] ?? '' }}</div>
                            <div class="box1_re">
                                {!! \Illuminate\Support\Arr::join($content_data['luan_giai']['ngu_hanh']['text'], '') !!}
                            </div>
                        </div>
                        <div class="groupbox">
                            <div class="title_result">{{ $content_data['luan_giai']['que_dich']['title'] ?? '' }}</div>
                            <div class="box1">
                                {!! \Illuminate\Support\Arr::join($content_data['luan_giai']['que_dich']['text'], '') !!}
                            </div>
                        </div>
                        <div class="groupbox">
                            <div class="title_result">{{ $content_data['luan_giai']['bat_tu']['title'] ?? '' }}</div>
                            <div class="box1">
                                <img class="lazy" alt="" src="data:image/png;base64,{{ $content_data['luan_giai']['bat_tu']['image'] ?? '' }}">
                            </div>
                        </div>
                        <div class="groupbox">
                            <div class="title_result"></div>
                            <div class="totalpoint">Tổng điểm:
                                <span>{{ $content_data['sim']['diem'] }} / 10</span>
                            </div>
                            <div class="box-muasim">
                                <a class="btn-muasim" href="{{ request()->get('sim') }}" class="btn-mua">Mua sim {{ str_add_offset(request()->get('sim'), '.', [4,8]) }}</a>
                            </div>
                        </div>
                        <hr/>
                        <div class="note_phongthuy">
                            {!! $content_data['luan_giai']['end']['text'] ?? '' !!}
                        </div>
                    </div>
                </section>
            @endif
        </section>
    </article>
@endsection
