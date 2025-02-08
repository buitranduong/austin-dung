@extends('layouts.blog')

@section('content')
    <main id="contents" class="container post-page">
        <section class="post-main">
            <h2 class="title-post">{{ __('Bài viết mới') }}</h2>
            @include('components.theme.section.blog.feature-post')
             <div class="d-flex post-large-block mb-40">
                <div class="col-50">
                    <x-theme.section.blog.category-post :category="$phong_thuy_sim_posts"/>
                </div>
                <div class="col-50">
                    <x-theme.section.blog.category-post :category="$sim_so_dep_posts"/>
                </div>
            </div>
             <x-theme.section.blog.grid-post :category="$tu_vi_posts"/>
        </section>
        @include('components.theme.aside.blog.aside-right')
    </main>
@endsection

