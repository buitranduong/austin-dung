document.addEventListener('DOMContentLoaded', function() {
    const hasCategoryClass = document.getElementById('category');
    const hasHeaderPCClass = document.querySelector('.header_mobile');
    const hasAdvancedFilter = document.querySelector('.advanced-filter');
    const hasFilterClose = document.querySelector('.filter__head__close');
    // Use function in mobile
    if (hasCategoryClass && hasHeaderPCClass) {
        const allTelecomCheckbox = document.getElementById('all-telecom');
        const allPrefixCheckbox = document.getElementById('all-prefix');

        const telecomCheckboxes = document.querySelectorAll('input[name="check-tel"]:not(#all-telecom)');
        const prefixCheckboxes = document.querySelectorAll('input[name="check-number"]:not(#all-prefix)');
        if (hasAdvancedFilter) {
            // Show advanced filter in category ---------------------------//
            document.querySelector('.advanced-filter').addEventListener('click', function() {
                var body = document.querySelector('body');
                if (body.classList.contains('overlay')) {
                    body.classList.remove('overlay');
                } else {
                    body.classList.add('overlay');
                }
            });
        }
        if(hasFilterClose) {
            // Show advanced filter in category ---------------------------//
            document.querySelector('.filter__head__close').addEventListener('click', function() {
                var body = document.querySelector('body');
                if (body.classList.contains('overlay')) {
                    body.classList.remove('overlay');
                }
            });
        }

        //Use filter category in mobile
        allTelecomCheckbox && allTelecomCheckbox.addEventListener('change', function() {
            telecomCheckboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }, this);
        });

        allPrefixCheckbox && allPrefixCheckbox.addEventListener('change', function() {
            prefixCheckboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }, this);
        });

        telecomCheckboxes && telecomCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    allTelecomCheckbox.checked = false;
                }
            });
        });

        prefixCheckboxes && prefixCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    allPrefixCheckbox.checked = false;
                }
            });
        });
    }
});
