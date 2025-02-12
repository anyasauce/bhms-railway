@extends('layouts.main')
@section('title', 'Main')

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center hero-content">
                <h1 class="hero-title text-white">Welcome to Boarding House Management</h1>
                <p class="hero-description text-white-50 mb-5">Streamline your boarding house operations with our modern
                    management system</p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('applications.create') }}" class="btn btn-custom btn-primary-custom">
                        <i class="bi bi-pencil-square me-2"></i>Apply Now
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-custom btn-outline-custom">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
