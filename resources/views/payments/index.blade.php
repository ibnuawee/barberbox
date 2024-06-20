@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Payment Methods</h1>
    <a href="{{ route('payments.create') }}" class="btn btn-primary mb-3">Add Payment Method</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Nomor</th>
                <th>Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paymentMethods as $method)
                <tr>
                    <td>{{ $method->name }}</td>
                    <td>{{ $method->nomor}}</td>
                    <td>{{ $method->details }}</td>
                    <td>
                        <form action="{{ route('payments.destroy', $method->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $paymentMethods->links() }}
</div>
@endsection
