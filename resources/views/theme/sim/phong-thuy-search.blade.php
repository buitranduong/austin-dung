@extends('layouts.phong-thuy')

@section('content')
    <article class="content-phongthuy">
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
                    <p>{!! $content_data['menh_chu'][0] !!}</p>
                    <p class="bold">{!! $content_data['menh_chu'][1] !!}</p>
                    <h2 class="pt-title">Tổng quan ưu, khuyết điểm của mệnh chủ</h2>
                    @foreach(\Illuminate\Support\Arr::except($content_data['menh_chu'], [0,1]) as $data)
                        <p>- {!! $data !!}</p>
                    @endforeach
                    <div class="result-sim">
                        <div class="result-sim__header">
                            <h2 class="result-sim__title">Sim hợp tuổi {{ request()->get('gt')=='nu'?'Nữ':'Nam' }} {{ request()->get('ns').'/'.request()->get('ts').'/'.request()->get('ls') }}</h2>
                        </div>
                        <div class="phongthuy-sim page-category">
                             <x-theme.section.table-sim-phongthuy :$mobile :data="$content_data['lists'] ?? []"/>
                        </div>
                    </div>
                    <div class="category-tag">
                        @for($i=1999; $i>=1960; $i--)
                            <a href="/sim-hop-tuoi-{{ $i }}">Sim hợp tuổi {{ $i }}</a>
                        @endfor
                    </div>
                @endif
            </div>
        </div>
    </article>
@endsection
