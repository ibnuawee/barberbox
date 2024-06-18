@extends('layouts2.app')

@section('content')
<div class="container">
    <h1>Top-up Balance</h1>
    <form action="{{ route('topups.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="payment_method_id">Payment Method</label>
            <select name="payment_method_id" id="payment_method_id" class="form-control">
                @foreach($paymentMethods as $method)
                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" name="amount" id="amount" class="form-control" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
