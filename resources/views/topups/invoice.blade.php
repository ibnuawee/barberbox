@extends('layouts2.app')

@section('content')
<div class="container">
    <h1>Invoice</h1>
    <div>
        <p><strong>Invoice ID:</strong> {{ $invoiceData['id'] }}</p>
        <p><strong>User:</strong> {{ $invoiceData['user'] }}</p>
        <p><strong>Payment Method:</strong> {{ $invoiceData['paymentMethod'] }}</p>
        <p><strong>Amount:</strong> {{ $invoiceData['amount'] }}</p>
        <p><strong>Admin Fee:</strong> {{ $invoiceData['adminFee'] }}</p>
        <p><strong>Total Amount:</strong> {{ $invoiceData['totalAmount'] }}</p>
        <p><strong>Status:</strong> {{ $invoiceData['status'] }}</p>
        <p><strong>Created At:</strong> {{ $invoiceData['createdAt'] }}</p>
    </div>
</div>
@endsection
