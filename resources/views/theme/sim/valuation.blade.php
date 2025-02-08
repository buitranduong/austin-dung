@extends('layouts.theme')

@section('content')
    <section class="sim-detail">
        <h1>{{ $seo_page->title }}</h1>
    </section>
    <form id="valuation_form" method="post" action="/dinh-gia-sim-ai" onsubmit="return validateValuationForm()" data-gtm-vis-has-fired1352901_310="1">
        @csrf
        <h3><strong>Định giá sim số đẹp</strong></h3>
        <label for="dienthoai">Số sim cần định giá*:</label>
        <input required="" placeholder="Nhập số sim cần định giá" name="sim" type="tel" id="dienthoai" value="{{ $sim }}" onkeyup="return onKeyPress()" autocomplete="off">
        @if($errors->has('sim'))
            <span class="error-hint">{{ $errors->first('sim') }}</span>
        @else
            <span class="error-hint hide">Vui lòng nhập số sim hợp lệ!</span>
        @endif
        <br>
        <div class="submit-datsim">
            <input type="submit" id="submit-datsim" value="Định giá sim" class="submit-btn btn-mua"/>
        </div>
    </form>
    @if(isset($valuation[$sim]))
        <div class="valuation-result">{{ __('Sim :sim được định giá: :value VNĐ', ['sim'=>$sim, 'value'=>$valuation[$sim]]) }}</div>
    @endif
    <x-theme.section.dynamic-content>
        {!! $seo_page->content !!}
    </x-theme.section.dynamic-content>
@endsection
