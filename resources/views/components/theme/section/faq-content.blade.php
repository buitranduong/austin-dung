@props([
    'faq'=>[]
])
@if(count($faq) > 0)
    <section id="faq">
        <h3>{{ __('CÂU HỎI THƯỜNG GẶP') }}</h3>
        @foreach($faq as $item)
            @php($link = !empty($item['url']) ? url()->current().str_replace('https://simthanglong.vn','', $item['url']) : url()->current().'#')
            <a id="{{ !empty($item['url']) ? str_replace([url(''), '/#','#'],'', $item['url']) : '' }}" class="question" href="{{ $link }}">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                    </svg>
                </span>
                <span>{{ $item['question'] ?? '' }}</span>
            </a>
            <div class="answer">
                {!! $item['answer'] ?? '' !!}
            </div>
        @endforeach
    </section>
@endif
