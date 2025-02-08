@props([
    'title'=>'',
    'subTitle'=>'',
    'className'=>'title-like',
    'link'=>'',
    'data'=> []
])
<section class="block-list-sim">
    <h2 class="title-block {{ $className }}"><a href="{{ $link }}" target="_blank">{{ $title }} @if($subTitle) <span class="view_pc-tab">{{ $subTitle }}</span> @endif</a></h2>
    <x-theme.section.list-sim :$data link="{{ $link }}" title="{{ __('Xem thêm :sim', ['sim'=>$title]) }}..." />
</section>

