@if($slot->isNotEmpty())
<section class="content-show-more">
    <div class="dynamic-height-wrap" id="home_content_text">
        {!! $slot !!}
    </div>

    <div id="btn_show_more">
        <span>{{ __('Xem thêm') }}</span>
        <i class="ic-angle-arrow"></i>
    </div>
</section>
@endif
