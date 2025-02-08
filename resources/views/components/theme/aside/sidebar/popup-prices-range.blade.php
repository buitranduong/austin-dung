<div class="popup-range-price">
    <div class="popup-rage-inner">
        <div id="close-range" class="close-popup-filter"><i class="icon-close"></i></div>
        <form action="" method="GET" onSubmit="return handlePricesForm(this)">
            <section class="wrapper">
                <h2>Hãy chọn mức giá phù hợp với bạn</h2>
                <div class="price-input">
                    <div class="field">
                        <span>Thấp</span>
                        <input name="price_min" type="text" class="display-min" id="min-price" placeholder="99.000" min="99000" max="15000000000">
                        <span class="unit">₫</span>
                    </div>
                    <div class="separator">-</div>
                    <div class="field">
                        <span>Cao</span>
                        <input name="price_max" type="text" class="display-max" id="max-price" placeholder="15.000.000.000" min="99000" max="15000000000">
                        <span class="unit">₫</span>
                    </div>
                </div>
                <div id="error-message" class="error-message"></div>
                <div class="text-center mt-30">
                    <button class="btn-search-by-price" type="submit">Tìm theo giá</button>
                </div>
            </section>
        </form>
    </div>
</div>
<div class="bg-overlay"></div>
