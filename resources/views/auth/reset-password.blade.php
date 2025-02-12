@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')

<div class="card glassmorphism">
    <div class="card-body">
        <form action="{{ route('update.password') }}" method="POST" id="reset-password-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="text-center mb-4">
                <h3 class="mb-2">Reset Password for</h3>
                <h6 class="font-weight-bold text-primary">{{ $email }}</h6>
                <p class="text-muted">Please create a new password to secure your account.</p>
            </div>
            <hr>
            <!-- Password Length Message -->
            <div id="password-message" class="mb-3">
                <span id="password-length" class="text-muted">Password must be at least 8 characters long.</span>
                <span id="password-length-icon"></span>
            </div>

            <!-- New Password Field -->
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="new-password" name="password"
                    placeholder="Enter new password" required>
                <label for="new-password">New Password</label>
            </div>

            <!-- Confirm Password Field -->
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="confirm-password" name="password_confirmation"
                    placeholder="Confirm new password" required>
                <label for="confirm-password">Confirm New Password</label>
            </div>

            <!-- Password Match Message -->
            <div id="confirm-password-message" class="mb-3">
                <span id="password-match" class="text-muted">Passwords must match.</span>
                <span id="password-match-icon"></span>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </div>
        </form>
    </div>
</div>

<script>
    const newPassword = document.getElementById('new-password');
    const confirmPassword = document.getElementById('confirm-password');
    const passwordLength = document.getElementById('password-length');
    const passwordLengthIcon = document.getElementById('password-length-icon');
    const passwordMatch = document.getElementById('password-match');
    const passwordMatchIcon = document.getElementById('password-match-icon');

    newPassword.addEventListener('input', function () {
        if (newPassword.value.length < 8) {
            passwordLength.style.color = 'red';
            passwordLengthIcon.innerHTML = '❌';
        } else {
            passwordLength.style.color = 'green';
            passwordLengthIcon.innerHTML = '✔️';
        }
    });

    confirmPassword.addEventListener('input', function () {
        if (newPassword.value !== confirmPassword.value) {
            passwordMatch.style.color = 'red';
            passwordMatchIcon.innerHTML = '❌';
        } else {
            passwordMatch.style.color = 'green';
            passwordMatchIcon.innerHTML = '✔️';
        }
    });
</script>

@endsection
