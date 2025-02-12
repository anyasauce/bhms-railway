@extends('layouts.niceadmin')
@section('title', 'Dashboard')

@section('content')
<div class="row g-4">
    <!-- Card for Boarders Count -->
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm border-start border-primary border-3 hover-scale">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-primary text-white me-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-muted mb-1">Total of Boarders</h5>
                        <p class="card-text display-6 fw-bold text-dark">{{ $boardersCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card for Available Rooms -->
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm border-start border-success border-3 hover-scale">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-success text-white me-3">
                        <i class="fas fa-door-open fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-muted mb-1">Available Rooms</h5>
                        <p class="card-text display-6 fw-bold text-dark">{{ $availableRooms }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card for Pending Payments -->
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm border-start border-danger border-3 hover-scale">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-danger text-white me-3">
                        <i class="fas fa-credit-card fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-muted mb-1">Pending Payments</h5>
                        <p class="card-text display-6 fw-bold text-dark">{{ $pendingPayments }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card for Total Boarder Amount -->
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm border-start border-warning border-3 hover-scale">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-warning text-white me-3">
                        <i class="fas fa-wallet fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-muted mb-1">Total Boarder Balance</h5>
                        <p class="card-text display-6 fw-bold text-dark">₱{{ number_format($totalBoarderBalance ?? 0, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card for Partial Amount -->
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm border-start border-warning border-3 hover-scale">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-warning text-white me-3">
                        <i class="fas fa-wallet fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-muted mb-1">Total Partial Revenue</h5>
                        <p class="card-text display-6 fw-bold text-dark">₱{{ number_format($totalPartialRevenue ?? 0, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card for Monthly Income -->
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm border-start border-warning border-3 hover-scale">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-warning text-white me-3">
                        <i class="fas fa-wallet fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-muted mb-1">Monthly Revenue</h5>
                        <p class="card-text display-6 fw-bold text-dark">₱{{ number_format($monthlyIncome ?? 0, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card for Total Income -->
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm border-start border-info border-3 hover-scale">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-info text-white me-3">
                        <i class="fas fa-coins fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-muted mb-1">Total Revenue</h5>
                        <p class="card-text display-6 fw-bold text-dark">₱{{ number_format($totalIncome ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
