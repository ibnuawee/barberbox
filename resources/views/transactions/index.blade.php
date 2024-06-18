@extends('layouts2.app')

@section('content')
<div class="container">
    <h1>Transaction History</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Date</th>
                <th>Balance Before</th>
                <th>Balance After</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ ucfirst($transaction->type) }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>{{ $transaction->created_at }}</td>
                    <td>{{ $transaction->balance_before }}</td>
                    <td>{{ $transaction->balance_after }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $transactions->links() }}
</div>
@endsection
