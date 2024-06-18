@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Settings</h1>
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="admin_fee_percentage">Admin Fee Percentage:</label>
            <input type="number" name="admin_fee_percentage" id="admin_fee_percentage" class="form-control" value="{{ $settings->admin_fee_percentage }}" min="0" max="100" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Settings</button>
    </form>
</div>
@endsection
