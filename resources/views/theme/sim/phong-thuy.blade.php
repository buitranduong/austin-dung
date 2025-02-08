@extends('layouts.phong-thuy')

@section('content')
    @if(!empty($sim_data))
        <div class="page-category content-phongthuy" style="padding: 0 5px">
            <div class="phongthuy_wp">
                @include('components.theme.section.form-phong-thuy')
            </div>
            <div class="checkbox_submit_search_desktop view_sp mb-40">
                <x-theme.block.corner-block :items="\App\Enums\PhongThuyMenu::MENU_TOP"/>
            </div>
            <div class="page-title-block">
                <h1>{{ optional($seo_page)->title ?? Str::headline($path) }}</h1>
                <span class="count-number">Số lượng: {{ number_format($sim_data->total() ?? 0)}}</span>
            </div>
            <div class="category-filter">
                @if($mobile)
                    <x-theme.block.list-filter-mobile :$active_filter_items :$heads />
                @else
                    <x-theme.block.list-filter-desktop :$active_filter_items />
                @endif
            </div>
            @if(!$mobile)
                <x-theme.section.table-sim :data="$sim_data ?? []" :$keyword/>
            @else
                <x-theme.section.list-sim :data="$sim_data ?? []"/>
                <script type="text/javascript">
                    function number_format(value, decimals = 0, decPoint = ',', thousandsSep = '.') {
                        let formatted = '';
                        const formatter = new Intl.NumberFormat(
                            'us',
                            {
                                minimumFractionDigits: decimals,
                                maximumFractionDigits: decimals
                            }
                        );
                        const parts = formatter.formatToParts(value);

                        parts.forEach(part => {
                            if (part.type === 'integer' || part.type === 'fraction') {
                                formatted += part.value;
                            } else if (part.type === 'group') {
                                formatted += thousandsSep;
                            } else if (part.type === 'decimal') {
                                formatted += decPoint;
                            }
                        });

                        return formatted;
                    }
                    document.addEventListener('DOMContentLoaded', function() {
                        const paginate = document.getElementById('btn-read-more');
                        if(paginate){
                            paginate.addEventListener("click", function (e){
                                e.preventDefault();
                                const loader = document.getElementById('page_loader');
                                loader.style.display = 'block';
                                const btnReadMore = this;
                                let isReceived = false;
                                const xhttp = new XMLHttpRequest();
                                xhttp.onload = function() {
                                    loader.style.display = 'none';
                                    const res = JSON.parse(this.responseText);
                                    if(res.hasOwnProperty('data') && res.data.length)
                                    {
                                        window.history.pushState(btnReadMore.href, '', btnReadMore.href);
                                        const count = res.data.length;
                                        if(res.next_page_url){
                                            btnReadMore.href = `${res.next_page_url}`;
                                            const remaining = (res.total - count * res.current_page);
                                            btnReadMore.innerHTML = `Xem tiếp <b>${number_format(remaining)}</b> sim`;
                                        }else{
                                            paginate.style.display = 'none';
                                        }
                                        const simItems = [];
                                        for (let i=0; i<count; i++)
                                        {
                                            if(res.data[i].hasOwnProperty('sell_price')){
                                                if(res.data[i].hasOwnProperty('adjust_percent') && res.data[i].adjust_percent < 0)
                                                {
                                                    simItems.push(`
                                                <a class="sim-card ${res.data[i].telcoText}" href="/${res.data[i].id}">
                                                    <div class="sim-number">${res.data[i].highlight}</div>
                                                    <div class="sim-price">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(
                                                        res.data[i].sell_price,
                                                    )}</div>
                                                    <div class="sim-price-old">${res.data[i].priceFormatted}</div>
                                                </a>
                                            `);
                                                }else{
                                                    simItems.push(`
                                                <a class="sim-card ${res.data[i].telcoText}" href="/${res.data[i].id}">
                                                    <div class="sim-number">${res.data[i].highlight}</div>
                                                    <div class="sim-price">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(
                                                        res.data[i].sell_price,
                                                    )}</div>
                                                </a>
                                            `);
                                                }
                                            }else{
                                                simItems.push(`
                                            <a class="sim-card ${res.data[i].telcoText}" href="/${res.data[i].id}">
                                                <div class="sim-number">${res.data[i].highlight}</div>
                                                <div class="sim-price">${res.data[i].priceFormatted}</div>
                                            </a>
                                        `);
                                            }
                                        }
                                        document.getElementById('list-sim').insertAdjacentHTML('beforeend', simItems.join(''));
                                    }else{
                                        paginate.style.display = 'none';
                                    }
                                };
                                xhttp.onreadystatechange = function () {
                                    if(this.readyState === 4){
                                        isReceived = true;
                                    }
                                };
                                xhttp.onprogress = function () {
                                    setTimeout(function(){
                                        if(!isReceived){
                                            xhttp.abort();
                                        }
                                    }, 1000);
                                };
                                xhttp.open("GET", this.href, true);
                                xhttp.setRequestHeader('Content-type','application/json');
                                xhttp.setRequestHeader('X-Requested-With','XMLHttpRequest');
                                xhttp.send();
                            });
                        }
                    });

                </script>
            @endif
            {!! optional($seo_page)->content !!}
        </div>
    @else
        <article class="content-phongthuy">
            <div class="content-inner">
                <h1 class="st_title">{{ optional($seo_page)->title }}</h1>
                <div class="phongthuy_wp">
                    @include('components.theme.section.form-phong-thuy')
                </div>
                <div class="checkbox_submit_search_desktop view_sp mb-40">
                    <x-theme.block.corner-block :items="\App\Enums\PhongThuyMenu::MENU_TOP"/>
                </div>
                @if($errors->any())
                    <div class="article-note">Qúy khách vui lòng cung cấp đầy đủ thông tin ngày tháng năm sinh để tìm kiếm kết quả phù hợp nhất !.</div>
                @endif
                <div class="result_pt">
                    {!! optional($seo_page)->content !!}
                </div>
                <div class="category-tag">
                    @for($i=1999; $i>=1960; $i--)
                        <a href="/sim-hop-tuoi-{{ $i }}">Sim hợp tuổi {{ $i }}</a>
                    @endfor
                </div>
            </div>
        </article>
    @endif
    @if($mobile)
        <x-theme.block.filters.filter-popup-adv :$active_filter_items/>
    @endif
@endsection
