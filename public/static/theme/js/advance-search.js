document.addEventListener('DOMContentLoaded', function() {
    const hasFilterClass = document.getElementById('advance_filter_block_new');

    // Use function in mobile
    if (hasFilterClass) {
        const hasFilterPCClass = document.querySelector('.item-filter-pc');
        const hasAdvancedFilter = document.querySelector('.advanced-filter-mobile');
        const hasFilterClose = document.querySelector('.filter__head__btn_close');
        const minPriceInput = document.getElementById('min-price-advance');
        const maxPriceInput = document.getElementById('max-price-advance');
        const filterItems = document.querySelectorAll('.advanced_filter li.filter-item');
        const advanceFilterPc = this.querySelector('.advance-filter-pc');
        const formSearchMobile = document.getElementById('form-search-mobile');
        const formSearchPc = document.getElementById('form-search-pc');
        const btnResetFormMb = document.getElementById('btn-reset-filter-mobile')

        function getFormatNumberPrice(e) {
            e.value = e.value
                .replace(/^0+/, "")
                .replace(/[^0-9]/g, "")
                .toString()
                .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        //Format input price
        if (minPriceInput) {
            document.getElementById('min-price-advance').addEventListener('input', function() {
                getFormatNumberPrice(this);
            });
        }
        if (maxPriceInput) {
            document.getElementById('max-price-advance').addEventListener('input', function () {
                getFormatNumberPrice(this);
            });
        }
        //Open advance filter on mobile
        if (hasAdvancedFilter) {
            hasAdvancedFilter.addEventListener('click', function() {
                var body = document.querySelector('body');
                if (body.classList.contains('advanced_overlay')) {
                    body.classList.remove('advanced_overlay');
                } else {
                    body.classList.add('advanced_overlay');
                }
            });
        }
        if(btnResetFormMb) {
            btnResetFormMb.addEventListener('click', function() {
                var body = document.querySelector('body');
                if (body.classList.contains('advanced_overlay')) {
                    body.classList.remove('advanced_overlay');
                    formSearchMobile.reset();
                }
            });
        }

        //Close advance filter on mobile
        if(hasFilterClose) {
            hasFilterClose.addEventListener('click', function() {
                var body = document.querySelector('body');
                if (body.classList.contains('advanced_overlay')) {
                    body.classList.remove('advanced_overlay');
                }
            });
        }

        // Filter category in pc
        filterItems.forEach(item => {
            item.addEventListener('click', function (event) {
                event.stopPropagation();
                const listPrice = this.querySelector('.advanced-list-price');
                const allListPrices = document.querySelectorAll('.advanced-list-price');
                allListPrices.forEach(price => {
                    if (price !== listPrice) {
                        price.style.display = 'none';
                    }
                });

                listPrice.style.display = (listPrice.style.display === 'flex') ? 'none' : 'flex';
                advanceFilterPc.style.display = 'none';
            });
        });
        // Filter click outner
        document.addEventListener('click', function (event) {
            const allListPrices = document.querySelectorAll('.advanced-list-price');
            allListPrices.forEach(price => {
                price.style.display = 'none';
            });
        });
        // Filter advance filter pc
        if (hasFilterPCClass) {
            const advanceFilterPc = this.querySelector('.advance-filter-pc');
            const allListPrices = document.querySelectorAll('.advanced-list-price');
            const btnReset= document.getElementById('btn-reset-filter');
            hasFilterPCClass.addEventListener('click', function (event) {
                event.stopPropagation();
                advanceFilterPc.style.display = (advanceFilterPc.style.display === 'flex') ? 'none' : 'flex';
                allListPrices.forEach(price => {
                    price.style.display = (advanceFilterPc.style.display === 'flex') ? 'none' : '';
                });
            });
            if (btnReset) {
                btnReset.addEventListener('click', function (event) {
                    event.stopPropagation();
                    formSearchPc.reset();
                    advanceFilterPc.style.display = (advanceFilterPc.style.display === 'flex') ? 'none' : 'flex';
                });
            }
            // Ngăn không cho advanceFilterPc bị ẩn khi click vào bên trong nó
            advanceFilterPc.addEventListener('click', function (event) {
                event.stopPropagation();
            });

            document.addEventListener('click', function () {
                advanceFilterPc.style.display = 'none';
            });
        }
    }
});
