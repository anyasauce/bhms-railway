(function () {
    'use strict';

    var forms = document.querySelectorAll('.needs-validation');

    var fullNameInput = document.getElementById('fullname');
    var emailInput = document.getElementById('email');

    var checkFullName = document.getElementById('checkFullName');
    var checkEmail = document.getElementById('checkEmail');

    fullNameInput.addEventListener('input', function () {
        if (fullNameInput.checkValidity()) {
            checkFullName.style.display = 'inline-block';
        } else {
            checkFullName.style.display = 'none';
        }
    });

    emailInput.addEventListener('input', function () {
        if (emailInput.checkValidity()) {
            checkEmail.style.display = 'inline-block';
        } else {
            checkEmail.style.display = 'none';
        }
    });

    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });
})();

