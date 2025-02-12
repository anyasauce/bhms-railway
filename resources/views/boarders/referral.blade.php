@extends('layouts.boarderportal')
@section('title', 'Refer & Earn Discounts')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white text-center">
            <h4>Refer & Earn Discounts!</h4>
        </div>

        <div class="card-body">
            <div class="row text-center mt-4">
                <div class="col-md-4">
                    <h5 class="text-muted">Your Referral Code:</h5>
                    <h3 class="text-success font-weight-bold">{{ $referralCode }}</h3>
                </div>
                <div class="col-md-4">
                    <h5 class="text-muted">Total People Referred:</h5>
                    <h3 class="text-primary font-weight-bold">{{ $totalReferrals }}</h3>
                </div>
                <div class="col-md-4">
                    <h5 class="text-muted">Your Earned Points:</h5>
                    <h3 class="text-warning font-weight-bold">{{ $totalPoints }}</h3>
                </div>
            </div>

            <hr>

            <div class="mt-4">
                <h5 class="text-center">People You Referred:</h5>
                @if($referredPeople->isEmpty())
                    <p class="text-muted text-center">No referrals yet. Start referring friends to earn rewards!</p>
                @else
                    <ul class="list-group mt-4">
                        @foreach($referredPeople as $referral)
                            <li class="list-group-item d-flex justify-content-between align-items-center mb-3">
                                <strong>{{ $referral->application->first_name }} {{ $referral->application->last_name }}</strong>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <hr>

            <!-- Redeem Discount Section -->
            <div class="mt-4= text-center">
                <h5>Redeem Your Points for Discounts:</h5>
                @php
                    $discounts = [
                        60 => 500,
                        50 => 400,
                        40 => 300,
                        20 => 200,
                        10 => 100
                    ];

                    $availableDiscount = 0;
                    foreach ($discounts as $points => $discount) {
                        if ($totalPoints >= $points) {
                            $availableDiscount = $discount;
                            break;
                        }
                    }
                @endphp

                @if($availableDiscount > 0)
                    <h4 class="text-success">You can redeem ₱{{ $availableDiscount }} off your next payment!</h4>
                    <form action="{{ route('redeem.discount') }}" method="POST">
                        @csrf
                        <input type="hidden" name="discount" value="{{ $availableDiscount }}">
                        <button type="submit" class="btn btn-primary mt-3">Redeem Now</button>
                    </form>
                @else
                    <p class="text-muted">Earn more points to unlock discounts!</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
