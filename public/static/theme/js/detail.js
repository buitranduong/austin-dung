document.addEventListener('DOMContentLoaded', function() {
    var checkbox = document.getElementById('invoice');
    var block = document.getElementById('masothue');
    var formOrder = document.getElementById('formOrder');

    if (checkbox) {
        checkbox.onchange = function() {
            if (checkbox.checked) {
                block.style.display = 'block';
            } else {
                block.style.display = 'none';
            }
        };
    }

    if(formOrder) {

    //Validate form order
    formOrder.addEventListener('submit', function(event) {
        var phoneInput = document.getElementById('phone');
        var fullNameInput = document.getElementById('fullName');
        var addressInput = document.getElementById('address');

        var phoneError = document.getElementById('phoneError');
        var fullNameError = document.getElementById('fullNameError');
        var addressError = document.getElementById('addressError');

        // Reset errors
        phoneError.textContent = '';
        fullNameError.textContent = '';
        addressError.textContent = '';

        // Validate phone number
        var phonePattern = /^\d{10,11}$/;
        if (phoneInput.value.trim() === '') {
            phoneError.textContent = 'Số điện thoại là bắt buộc';
            event.preventDefault();
        }else if (!phonePattern.test(phoneInput.value)) {
            phoneError.textContent = 'Số điện thoại không hợp lệ';
            event.preventDefault();
        }

        // Validate required fields
        if (fullNameInput.value.trim() === '') {
            fullNameError.textContent = 'Họ và tên là bắt buộc';
            event.preventDefault();
        }

        if (addressInput.value.trim() === '') {
            addressError.textContent = 'Địa chỉ là bắt buộc';
            event.preventDefault();
        }
    });

    // Hàm tính toán số tiền trả góp mỗi tháng
    function calculateMonthlyPayment() {
        var hasDownPayment = document.getElementById('downPayment');
        if (hasDownPayment) {
            var downPayment = parseFloat(hasDownPayment.value);
            var totalAmount = parseFloat(document.getElementById('giaban').value);
            var months = parseInt(document.getElementById('months').value);
            var loanAmount = totalAmount * (1 - downPayment);
            var monthlyPayment = loanAmount / months;
            
            document.getElementById('monthlyPayment').innerText = monthlyPayment.toLocaleString() + '₫';
        }

    }

    calculateMonthlyPayment();
    formOrder.addEventListener('change', calculateMonthlyPayment);
    }
});