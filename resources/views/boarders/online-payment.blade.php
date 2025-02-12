@extends('layouts.boarderportal')
@section('title', 'Online Payment')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h4><i class="fas fa-credit-card"></i> Online Payment</h4>
        </div>
        <div class="card-body">
            @if($payments->isEmpty())
                <div class="alert alert-info mt-4">
                    <h5 class="text-center text-primary">No upcoming payment.</h5>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Payment ID</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td><strong>₱{{ number_format($payment->amount, 2) }}</strong></td>
                                    <td>
                                        @if($payment->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($payment->status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @if($payment->status == 'pending')
                                            <a href="{{ route('payment.pay', $payment->id) }}" class="btn btn-success btn-sm"
                                                data-toggle="tooltip" data-placement="top" title="Proceed with payment">
                                                <i class="fas fa-money-check-alt"></i> Pay Online
                                            </a>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-check-circle"></i> Paid
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card mt-4 shadow-lg border-0">
        <div class="card-header bg-secondary text-white">
            <h4><i class="fas fa-history"></i> Recent Transactions</h4>
        </div>
        <div class="card-body">
            @if($transactions->isEmpty())
                <div class="alert alert-light text-center">
                    <h5 class="text-muted">No recent transactions found.</h5>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Transaction ID</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ ucfirst($transaction->type) }}</td>
                                    <td><strong>₱{{ number_format($transaction->amount, 2) }}</strong></td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ $transaction->created_at->format('Y-m-d h:i A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Tooltips Initialization -->
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

@endsection
