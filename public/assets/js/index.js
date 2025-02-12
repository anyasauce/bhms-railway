document.getElementById('show_password').addEventListener('click', function() {
    var passwordField = document.getElementById('admin_password');
    if (this.checked) {
        passwordField.type = 'text';
    } else {
        passwordField.type = 'password';
    }
});

document.getElementById('forgotpassword-link').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('forgot-password-form').style.display = 'block';
});

document.getElementById('back-to-login-link').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('forgot-password-form').style.display = 'none';
    document.getElementById('login-form').style.display = 'block';
});
