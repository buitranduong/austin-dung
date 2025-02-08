@extends('layouts.theme')

@section('content')
    <div class="container page-container">
        <h1>{{ $post->title }}</h1>
        <div class="entry-content">{!! $post->content !!}</div>
    </div>
@endsection
