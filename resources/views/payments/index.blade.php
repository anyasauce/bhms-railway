@extends('layouts.niceadmin')

@section('title', 'Payments')

@section('content')
<div class="container mt-4">
    @if($payments->isEmpty())
        <div class="alert alert-warning" role="alert">
            No payment available.
        </div>
    @else
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title text-white">Pending Payment</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="payment" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Boarder Name</th>
                                <th>Room Name</th>
                                <th>Amount</th>
                                <th>Partial Amount</th>
                                <th>Balance</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->first_name . " " . $payment->last_name}}</td>
                                    <td>{{ $payment->room_name }}</td>
                                    <td>₱{{ $payment->amount }}</td>
                                    <td>₱{{ $payment->partial_amount }}</td>
                                    <td>₱{{ $payment->amount - $payment->partial_amount }}</td>
                                    <td>{{ $payment->payment_due_date }}</td>
                                    <td>
                                        @if($payment->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($payment->status == 'partial')
                                            <span class="badge bg-warning">Partial</span>
                                        @elseif($payment->status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info text-white" data-bs-toggle="modal"
                                            data-bs-target="#paymentModal{{ $payment->id }}"><i class="bi bi-eye"></i></button>

                                        <!-- Modal for payment details -->
                                        <div class="modal fade" id="paymentModal{{ $payment->id }}" tabindex="-1" aria-labelledby="paymentModalLabel{{ $payment->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="paymentModalLabel{{ $payment->id }}">Payment Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Name:</strong> {{ $payment->name }}</p>
                                                        <p><strong>Room Name:</strong> {{ $payment->room_name }}</p>
                                                        <p><strong>Amount:</strong> ₱{{ $payment->amount }}</p>
                                                        <p><strong>Description:</strong> {{ $payment->description ?? 'N/A' }}</p>
                                                        <p><strong>Payment Due Date:</strong> {{ $payment->payment_due_date }}</p>
                                                        <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
                                                        <p><strong>Created At:</strong> {{ $payment->created_at }}</p>
                                                        <p><strong>Updated At:</strong> {{ $payment->updated_at }}</p>

                                                        @if(in_array($payment->status, ['pending', 'partial']))
                                                            <div class="mb-3">
                                                                <form action="{{ route('payments.partialPayment', $payment->id) }}" method="POST">
                                                                <label for="partialAmount" class="form-label">Enter Partial Payment Amount</label>
                                                                <input type="number" name="partialAmount" class="form-control" placeholder="₱" min="0" max="{{ $payment->amount }}"
                                                                    required>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                            @csrf
                                                            <input type="hidden" name="payment_id" value="{{ $payment->id }}">

                                                            <button type="submit" class="btn btn-success">Submit Partial Payment</button>
                                                        </form>

                                                        <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
            $('#payment').DataTable();
        });
    </script>
@endsection
