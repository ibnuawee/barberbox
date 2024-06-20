@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Payment Method</h1>
    <form action="{{ route('payments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nomor" class="form-label">Nomor rekening</label>
            <input type="tel" name="nomor" id="nomor" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="details" class="form-label">Details</label>
            <textarea name="details" id="details" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</div>
@endsection
