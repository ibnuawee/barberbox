@extends('layouts2.app')

@section('content')
<div class="container">
    <h1>Payment Details</h1>
    <div>
        <p><strong>Invoice:</strong> {{ $topUp->invoice }}</p>
        <p><strong>Payment Method:</strong> {{ $topUp->paymentMethod->name }}</p>
        <p><strong>Amount:</strong> {{ $topUp->amount }}</p>
        <p><strong>Admin Fee:</strong> {{ $topUp->admin_fee }}</p>
        <p><strong>Total Amount:</strong> {{ $topUp->total_amount }}</p>
        <p><strong>Payment Number:</strong> {{ $topUp->paymentMethod->number }}</p>
        <p><strong>Payment Details:</strong> {{ $topUp->paymentMethod->details }}</p>
    </div>
    <form action="{{ route('topups.uploadProof', $topUp->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="payment_proof">Payment Proof</label>
            <input type="file" name="payment_proof" id="payment_proof" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload Payment Proof</button>
    </form>
    <a href="{{ route('topups.invoice', $topUp->id) }}" class="btn btn-secondary mt-3">Download Invoice</a>
</div>
@endsection
