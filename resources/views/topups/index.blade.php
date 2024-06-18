@extends('layouts2.app')

@section('content')
<div class="container">
    <h1>My Top-ups</h1>
    <a href="{{ route('topups.create') }}" class="btn btn-primary mb-3">New Top-up</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Topup id</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Payment Proof</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topUps as $topUp)
                <tr>
                    <td>{{ $topUp->id }}</td>
                    <td>{{ $topUp->invoice }}</td>
                    <td>{{ $topUp->amount }}</td>
                    <td>{{ $topUp->paymentMethod->name }}</td>
                    <td>
                        @if($topUp->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($topUp->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($topUp->status == 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>
                        @if($topUp->payment_proof)
                            <a href="{{ Storage::url($topUp->payment_proof) }}" target="_blank">View Proof</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $topUp->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $topUps->links() }}
</div>
@endsection
