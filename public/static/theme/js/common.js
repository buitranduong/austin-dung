document.addEventListener('DOMContentLoaded', function() {
    const hasHeaderPCClass = document.querySelector('.header_mobile');
    const filterItems = document.querySelectorAll('.filter li.filter-item');
    const hasBtnShowmore = document.getElementById("btn_show_more");
    var current_scroll = 0;

    // Use function in mobile 
    if (hasHeaderPCClass) {
        // Menu Click ---------------------------//
        document.querySelector('.header-menuBtn').addEventListener('click', function() {
            var body = document.querySelector('body');
            if (body.classList.contains('open-menu')) {
                body.classList.remove('open-menu');
            } else {
                body.classList.add('open-menu');
            }
        });

        // fixed header in mobile ----------------//
        window.addEventListener('scroll', function(e) {
            if (window.pageYOffset > 50) {
                if (window.pageYOffset > current_scroll) {
                    document.querySelector(".header_mobile").classList.add("hide");
                } else {
                    document.querySelector(".header_mobile").classList.remove("hide");
                }
                current_scroll = window.pageYOffset;
            }
        });

        // Show tooltip when focus input search ----------------//
        document.querySelector(".search-input").addEventListener("keyup", function() {
            var searchInput = document.querySelector(".search-input").value.trim();
            var searchHelper = document.querySelector(".search-helper");
            var searchText = document.querySelector(".search-submit").value.trim();
            if (searchInput !== "") {
                var e = searchInput.toLowerCase().replace(/[^0-9^*^x]/g, "").replace(/\*+/g, "*");
                if (isNaN(e)) {
                    if (searchHelper) searchHelper.style.display = "none";
                    if(searchText) searchText.style.display = "none";
                } else {
                    if(searchHelper) searchHelper.style.display = "none";
                    if(searchText) searchText.style.display = "none";
                }
            } else {
                if(searchHelper) searchHelper.style.display = "block";
                if(searchText) searchText.style.display = "block";
            }
        });

        document.querySelector(".search-input").addEventListener("focus", function() {
            document.querySelector(".search-helper").style.display = "block";
            document.querySelector(".search-submit span").style.display = "block";
        });

        document.querySelector(".search-input").addEventListener("blur", function() {
            document.querySelector(".search-helper").style.display = "none";
            document.querySelector(".search-submit span").style.display = "none";
        });

    }
    if(hasBtnShowmore) {
        document.getElementById("btn_show_more").addEventListener("click", function() {
            var btn = document.querySelector("#btn_show_more span");
            var content = document.getElementById("home_content_text");
            if (btn.textContent === "Xem thêm") {
                content.style.height = "auto";
                btn.textContent = "Thu gọn";
                btn.parentNode.classList.add("btn_less_more");
            } else {
                content.style.height = "300px";
                btn.textContent = "Xem thêm";
                btn.parentNode.classList.remove("btn_less_more");
            }
        });
    }

    // Filter category in pc
    filterItems.forEach(item => {
        item.addEventListener('click', function (event) {
            event.stopPropagation();
            const listPrice = this.querySelector('.list-price');
            const allListPrices = document.querySelectorAll('.list-price');
            allListPrices.forEach(price => {
                if (price !== listPrice) {
                    price.style.display = 'none';
                }
            });

            listPrice.style.display = (listPrice.style.display === 'block') ? 'none' : 'block';
        });
    });
    // Filter click out ner
    document.addEventListener('click', function (event) {
        const allListPrices = document.querySelectorAll('.list-price');
        allListPrices.forEach(price => {
            price.style.display = 'none';
        });
    });

    //Toggle button in mobile
    var toggleBtns = document.querySelectorAll('.toggle-btn');
    toggleBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var target = document.querySelector(this.getAttribute('data-target'));
            if (target.style.display === 'none' || target.style.display === '') {
                target.style.display = 'block';
            } else {
                target.style.display = 'none';
            }
            this.classList.toggle('active');
        });
    });
    
});

document.addEventListener("DOMContentLoaded", function() {
    var lazyImages = document.querySelectorAll('.lazy');
    const hasClassPrice = document.querySelectorAll('.popup-range-price');
    const hasRangeFilter = document.querySelectorAll('.range-price-filter');
    const hasSidebarLeft = document.getElementById("sidebar-left");
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');
    const copyButton = document.getElementById('copyButton');
    
    
    var lazyLoad = function() {
        lazyImages.forEach(function(img) {
            if (img.getBoundingClientRect().top < window.innerHeight && img.getBoundingClientRect().bottom >= 0 && getComputedStyle(img).display !== 'none') {
                if (img.dataset.src) {
                    img.setAttribute('src', img.dataset.src);
                }
                img.style.opacity = 1;
            }
        });

        lazyImages = document.querySelectorAll('.lazy');
    }

    lazyLoad();

    window.addEventListener('scroll', lazyLoad);
    window.addEventListener('resize', lazyLoad);
    window.addEventListener('orientationchange', lazyLoad);

    if(hasClassPrice) {
        function formatNumberPrice(e) {
            e.value = e.value
            .replace(/^0+/, "")   
            .replace(/[^0-9]/g, "") 
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, "."); 
        }
        if (minPriceInput) {
            document.getElementById('min-price').addEventListener('input', function() {
                formatNumberPrice(this);
                validateMinPrice(this);
            });
        }
        if (maxPriceInput) {
            document.getElementById('max-price').addEventListener('input', function () {
                formatNumberPrice(this);
                validateMaxPrice(this);
            });
        }

        function validateMinPrice(input) {
            

            const currentPriceValue = parseInt(input.value.replace(/\./g, ''), 10);
            const maxPrice = parseInt(maxPriceInput.value.replace(/\./g, ''));
            const minAllowedValue = parseInt(input.min, 10);
            const maxAllowedValue = parseInt(input.max, 10);
            const errorMessage = document.getElementById('error-message');

            if (currentPriceValue < minAllowedValue) {
                errorMessage.textContent = `Giá thấp không được nhỏ hơn ${minAllowedValue.toLocaleString()}₫.`;
            } else if (currentPriceValue > maxAllowedValue) {
                errorMessage.textContent = `Giá thấp không được cao hơn ${maxAllowedValue.toLocaleString()}₫.`;
            } else if (currentPriceValue > maxPrice) {
                errorMessage.textContent = `Giá nhập vào không được thấp hơn giá cao`;
            } else {
                errorMessage.textContent = '';
            }
        }

       function validateMaxPrice(input) {
            const minPriceInput = document.getElementById('min-price');

            const currentPriceValue = parseInt(input.value.replace(/\./g, ''), 10);
            const minPrice = parseInt(minPriceInput.value.replace(/\./g, ''));
            const minAllowedValue = parseInt(input.min, 10);
            const maxAllowedValue = parseInt(input.max, 10);
            const errorMessage = document.getElementById('error-message');

            if (currentPriceValue < minAllowedValue) {
                errorMessage.textContent = `Giá thấp không được nhỏ hơn ${minAllowedValue.toLocaleString()}₫.`;
            } else if (currentPriceValue > maxAllowedValue) {
                errorMessage.textContent = `Giá thấp không được cao hơn ${maxAllowedValue.toLocaleString()}₫.`;
            } else if (currentPriceValue < minPrice) {
                errorMessage.textContent = `Giá nhập vào không được thấp hơn giá thấp`;
            } else {
                errorMessage.textContent = '';
            }
        }

        // Show popup range price filter-----------//
        if (hasRangeFilter && hasSidebarLeft) {
            document.querySelector('.range-price-filter').addEventListener('click', function () {
                var body = document.querySelector('body');
                if (body.classList.contains('open-popup')) {
                    body.classList.remove('open-popup');
                } else {
                    body.classList.add('open-popup');
                }
            });
            document.querySelector('.close-popup-filter')?.addEventListener('click', function () {
                var body = document.querySelector('body');
                if (body.classList.contains('open-popup')) {
                    body.classList.remove('open-popup');
                } else {
                    body.classList.add('open-popup');
                }
            });

            document.addEventListener('keydown', function(event) {
                var body = document.querySelector('body');
                if (event.key === 'Escape' || event.keyCode === 27) {
                    if (body.classList.contains('open-popup')) {
                        body.classList.remove('open-popup');
                    }
                }
            });
        }
    }

    if(copyButton) {
        copyButton.addEventListener('click', function () {
            var textToCopy = document.getElementById('textToCopy').innerText;
            navigator.clipboard.writeText(textToCopy);
        });
    }
});

document.addEventListener('DOMContentLoaded', (event) => {
    const hasBtnTocLink = document.getElementById("block_toc_link");
    const tocToggleBtn = document.getElementById('toc_title_toggle');
    const tocList = document.querySelector('.toc-list-link');
    if (hasBtnTocLink && tocToggleBtn) {
        tocToggleBtn.addEventListener('click', () => {
            if (tocList.style.display === 'block' || tocList.style.display === '') {
                tocList.style.display = 'none';
            } else {
                tocList.style.display = 'block';
            }
        });
    }
});