@extends('layouts.boarderportal')

@section('title', 'Profile')

@section('content')
<!-- Left side columns -->
<div class="col-lg-12">
    <div class="row">
        <div class="card">
            <div class="card-header">Update Profile Boarders</div>

            @if(Auth::check())
                <div class="container mt-3" style="font-family: 'Poppins', sans-serif;">
                    <br>
                    <form action="{{ route('boarders.updateProfile') }}" method="POST">
                        @csrf
                        <div class="container">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="first_name" class="form-label"><strong>Boarder First Name</strong></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required
                                        placeholder="Enter Boarder First Name" value="{{ Auth::user()->first_name }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="last_name" class="form-label"><strong>Boarder Last Name</strong></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required placeholder="Enter Boarder Last Name"
                                        value="{{ Auth::user()->last_name }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="admin_email" class="form-label"><strong> Email</strong></label>
                                    <input type="email" class="form-control" id="admin_email" name="email" required
                                        placeholder="Enter Admin Email" value="{{ Auth::user()->email }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="admin_password" class="form-label"><strong> Password</strong></label>
                                    <input type="password" class="form-control" id="admin_password" name="password"
                                        placeholder="Enter New Admin Password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <input class="form-check-input" type="checkbox" id="show_password">
                                    <label class="form-check-label" for="show_password">Show Password</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" style="color:white;" class="btn btn-primary"
                                    name="update_official">Update your Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class='container mt-5'>
                    <div class='alert alert-danger'>Boarders profile not found.</div>
                </div>
            @endif
        </div>
    </div>
</div><!-- End Left side columns -->
@endsection
