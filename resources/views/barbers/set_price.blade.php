@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Set Harga Potong Rambut</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('barber.set_price.store') }}">
                @csrf
                <div class="form-group">
                    <label for="haircut_price">Harga Potong Rambut</label>
                    <input id="haircut_price" type="number" class="form-control @error('haircut_price') is-invalid @enderror" name="haircut_price" value="{{ old('haircut_price') ?? $user->haircut_price }}" required>
                    @error('haircut_price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan Harga</button>
            </form>
        </div>
    </div>
</div>
@endsection
