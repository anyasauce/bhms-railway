@extends('layouts.boarderportal')
@section('title', 'Boarders Portal')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Boarder's Dashboard</h4>
        </div>
        <div class="card-body">
            <h5 class="mt-4">Your Balance: <strong class="text-success">₱{{ number_format($balance, 2) }}</strong></h5>
        </div>
    </div>

    <div class="mt-4">
        <div class="card-header bg-success text-white">
            <h5>Recent Transactions</h5>
        </div>

        <div class="table-responsive shadow-lg rounded">
            <table class="table table-hover table-bordered align-middle">
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th><i class="fas fa-calendar-alt"></i> Date</th>
                        <th><i class="fas fa-money-bill-wave"></i> Amount</th>
                        <th><i class="fas fa-credit-card"></i> Partial Amount</th>
                        <th><i class="fas fa-info-circle"></i> Status</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if($transactions->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-muted">No transactions found</td>
                        </tr>
                    @else
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->created_at->format('F d, Y') }}</td>
                                <td class="fw-bold text-success">₱{{ number_format($transaction->amount, 2) }}</td>
                                <td class="fw-bold text-warning">
                                    @if($transaction->partial_amount)
                                        ₱{{ number_format($transaction->partial_amount, 2) }}
                                    @else
                                        ₱0.00
                                    @endif
                                </td>
                                <td>
                                    @if($transaction->status == 'pending')
                                        <span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half"></i> Pending</span>
                                    @elseif($transaction->status == 'partial')
                                        <span class="badge bg-info"><i class="fas fa-credit-card"></i> Partial</span>
                                    @elseif($transaction->status == 'paid')
                                        <span class="badge bg-primary"><i class="fas fa-money-bill-wave"></i> Paid</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="fas fa-question-circle"></i> Unknown</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>


    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h5><i class="fas fa-calendar-check"></i> Upcoming Payments</h5>
        </div>
        <div class="card-body">
            @if($upcomingPayments->isEmpty())
                <p class="text-center text-muted mt-4">No upcoming payments</p>
            @else
                <div class="list-group">
                    @foreach($upcomingPayments as $payment)
                        <div class="list-group-item d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <strong>{{ $payment->payment_due_date->format('F d, Y') }}</strong>
                                <br>
                                <small class="text-muted">Due date</small>
                            </div>
                            <div class="fw-bold text-success">
                                ₱{{ number_format($payment->amount, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="card mt-4 shadow-lg border-0 rounded-3">
        <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-file-invoice-dollar"></i> Payment Summary</h5>
            <i class="fas fa-cogs"></i>
        </div>
        <div class="card-body mt-5">
            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm rounded p-3">
                        <i class="fas fa-check-circle fa-3x text-success"></i>
                        <h6 class="mt-3">Total Paid</h6>
                        <p class="h4 text-success">₱{{ number_format($totalPaid, 2) }}</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm rounded p-3">
                        <i class="fas fa-credit-card fa-3x text-info"></i>
                        <h6 class="mt-3">Total Partial</h6>
                        <p class="h4 text-info">₱{{ number_format($totalPartial, 2) }}</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm rounded p-3">
                        <i class="fas fa-hourglass-half fa-3x text-warning"></i>
                        <h6 class="mt-3">Total Due</h6>
                        <p class="h4 text-warning">₱{{ number_format($totalDue, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
@endsection
