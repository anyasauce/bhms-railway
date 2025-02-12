@extends('layouts.niceadmin')
@section('title', 'Manage Applicants')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title text-white">Applicants List</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="applicant" class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Referral Code</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $index => $applicant)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $applicant->first_name }} {{ $applicant->last_name }}</td>
                                <td>{{ $applicant->email }}</td>
                                <td>{{ $applicant->referral_code ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge
                                        {{ $applicant->status == 'pending' ? 'bg-warning' : 'bg-success' }}">
                                        {{ ucfirst($applicant->status) }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('update.applicant.status', $applicant->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-select" onchange="this.form.submit()">
                                            <option value="pending" {{ $applicant->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $applicant->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function () {
            $('#applicant').DataTable();
        });
    </script>
@endsection
