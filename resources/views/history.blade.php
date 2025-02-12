@extends('layouts.niceadmin')

@section('title', 'Payments History')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Payment History</h3>

    @if($payments->isEmpty())
        <div class="alert alert-warning" role="alert">
            No payment history available.
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title text-white">Payment History</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="history" class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Boarder Name</th>
                                <th>Room</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->first_name }} {{ $payment->last_name }}</td>
                                    <td>{{ $payment->room_name }}</td>
                                    <td>₱{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge {{ $payment->status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

    <script>
        $(document).ready(function () {
            $('#history').DataTable();
        });
    </script>
@endsection
