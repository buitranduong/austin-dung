@extends('layouts.theme')

@section('content')
    <div class="page-category">
        <div class="page-title-block">
            <h1>{{ optional($seo_page)->title ?? Str::headline($path) }}</h1>
            <span class="count-number">Số lượng: {{ number_format($sim_data->total() ?? 0)}}</span>
        </div>
        <div class="category-filter">
            <div class="scroll-x home-filter view_tab-sp">
                <div class="clearfix">
                    @if($heads && count($heads ?? []) > 1)
                        <x-theme.block.filters.filter-heads :$heads :$active_filter_items/>
                    @else
                        <div style="display: none" class="sim-card-item sim-card-net">
                            <a href="javascript: toggleFilterWithLink('h','09', '/sim-dau-so-$item', 1)" title="Sim số đầu 09" role="button">09x</a>
                        </div>
                        <div style="display: none" class="sim-card-item sim-card-net">
                            <a href="javascript: toggleFilterWithLink('h','08', '/sim-dau-so-$item', 1)" title="Sim số đầu 08" role="button">08x</a>
                        </div>
                    @endif
                    @if(!$heads)
                        <x-theme.block.filters.filter-tel :items="\App\Enums\SimType::FILTER_TEL" :$active_filter_items/>
                    @endif
                </div>
            </div>
            <div class="scroll-x home-filter view_tab-sp pt-10">
                <div class="clearfix">
                    <x-theme.block.filters.filter-prices :items="\App\Enums\SimType::FILTER_PRICES" :$active_filter_items/>
                </div>
            </div>
            <x-theme.block.adv-filter-desktop :$active_filter_items />
        </div>
        @if($sim_data && method_exists($sim_data, 'total') && !$sim_data->total())
            @if (!empty($keyword) and count($active_filter_items['active_keys'])==0)
                <div class="block-not-found">
                    <p>SIM DẠNG <span>{{ $keyword }}</span> CHƯA ĐƯỢC CẬP NHẬT LÊN WEB</p>
                    Quý khách có nhu cầu sử dụng số dạng này có thể gọi trực tiếp đến Hotline
                    <strong><a href="tel:{{ str_replace(['.',',',' '],'', $hotlineSetting->seller) }}" title="Hotline: {{ $hotlineSetting->seller }}">{{ $hotlineSetting->seller }}</a></strong> để được phục vụ nhanh nhất!
                    @if($sim_suggess && method_exists($sim_suggess, 'total') && $sim_suggess->total())
                        <p>Hoặc quý khách có thể tham khảo danh sách số tương tự dưới đây:</p>
                    @endif
                </div>
            @else
                <div class="block-not-found">
                    <p>SIM BẠN TÌM KIẾM CHƯA ĐƯỢC CẬP NHẬT LÊN WEB</p>
                    Quý khách có nhu cầu sử dụng số dạng này có thể gọi trực tiếp đến Hotline
                    <strong><a href="tel:{{ str_replace(['.',',',' '],'', $hotlineSetting->seller) }}" title="Hotline: {{ $hotlineSetting->seller }}">{{ $hotlineSetting->seller }}</a></strong> để được phục vụ nhanh nhất!
                </div>
            @endif
        @endif
        @if(!$mobile)
            <x-theme.section.table-sim :data="$sim_data->total() > 0 ? $sim_data : $sim_suggess" :$keyword/>
        @else
            <x-theme.section.list-sim :data="$sim_data->total() > 0 ? $sim_data : $sim_suggess" :$mobile/>
        @endif
        @if(!empty($seo_page->related_content))
            <x-theme.block.related-content as="search-related" :items="$seo_page->related_content"/>
        @endif
        @if(!empty($seo_page->h2) && !empty($seo_page->content))
            <div class="common-keyword pt-15">
                <h2>{{ $seo_page->h2 }}</h2>
            </div>
        @endif
    </div>
    @if(!empty($seo_page->content))
        <x-theme.section.dynamic-content>
            {!! html_entity_decode($seo_page->content) !!}
        </x-theme.section.dynamic-content>
    @endif
    <x-theme.section.faq-content :faq="optional($seo_page)->faq"/>
    @if($mobile)
        <x-theme.block.filters.filter-popup-adv :$active_filter_items/>
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
@endsection
