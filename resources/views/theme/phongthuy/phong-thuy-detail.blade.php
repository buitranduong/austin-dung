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
                <section class="phongthuy-details">
                    <div class="phongthuy-details__inner">
                        <h2 class="ptm-title">{!! $content_data['luan_giai']['title'] ?? '' !!}:</h2>
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
                        <x-theme.section.dynamic-content>
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
                                            @foreach($content_data['luan_giai']['am_duong']['day_so'] as $item)
                                                <td class="text-center" style="background-color: {{ $item['color'] }}">{{ $item['number'] }}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach($content_data['luan_giai']['am_duong']['day_so'] as $item)
                                                <td class="text-center" style="background-color: {{ $item['color'] }}">{{ $item['text'] }}</td>
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
                        </x-theme.section.dynamic-content>
                        <div class="groupbox">
                            <p>Có câu, Cầu Phúc chưa chắc đã được Phúc, nhưng tạo Phúc thì chắc chắn được Phúc. Thay đổi để tốt hơn, để Nhân Tâm, Phúc Đức có thể hóa hung thành cát, gặp dữ hóa lành đó gọi là thuận Phong Thủy số cải vận.</p>
                            <div class="title_result">Kết quả phong thủy sim {!! $content_data['sim']['highlight'] ?? $sim !!}</div>
                            <div class="totalpoint">Tổng điểm:
                                <span>{{ $content_data['sim']['diem'] }} / 10</span>
                            </div>
                            @if(!$content_data['sim']['sold'])
                                <div class="box-muasim">
                                    <a class="btn-muasim" href="{{ request()->get('sim') }}">Mua ngay sim {!! $content_data['sim']['highlight'] ?? $sim !!}</a>
                                </div>
                            @endif
                            <p><strong>Kính chúc quý vị, tìm được la bàn cuộc đời mình, tìm được may mắn và an lạc hoan hỉ, một cách giản đơn với đời sống Phong thủy số, để luôn đắc Sinh Khí, vượng Thiên Y, trợ Phúc Đức. Để luôn được Gia hộ độ trì và Hanh thông quang đạt Viên mãn. Phúc Khang An Thái, Phúc Lai Tai Tống, Phúc Lộc tựa Vân Lai.</strong></p>
                        </div>
                        <hr/>
                        <div class="note_phongthuy">
                            <p>© 2009 Simthanglong.vn</p>
                            <p>Công cụ này được xây dựng dựa trên các quan niệm về lý số phương đông.</p>
                        </div>
                    </div>
                </section>
            @endif
        </section>
    </article>
@endsection
