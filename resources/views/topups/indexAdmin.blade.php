@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pending Top-ups</h1>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Proof</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topUps as $topUp)
                <tr>
                    <td>{{ $topUp->user->name }}</td>
                    <td>{{ $topUp->amount }}</td>
                    <td>{{ $topUp->paymentMethod->name }}</td>
                    <td><a href="{{ Storage::url($topUp->payment_proof) }}" target="_blank">View Proof</a></td>
                    <td>
                        <form action="{{ route('topups.approve', $topUp->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                        <form action="{{ route('topups.reject', $topUp->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $topUps->links() }}
</div>
@endsection
