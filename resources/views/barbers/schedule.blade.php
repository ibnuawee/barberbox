@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Atur Jadwal Kerja</h1>
    <form action="{{ route('barber.schedule.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="work_start_time">Jam Mulai Kerja</label>
            <input id="work_start_time" type="time" class="form-control @error('work_start_time') is-invalid @enderror" name="work_start_time" value="{{ old('work_start_time') ?? $barber->work_start_time }}" required>
            @error('work_start_time')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="work_end_time">Jam Selesai Kerja</label>
            <input id="work_end_time" type="time" class="form-control @error('work_end_time') is-invalid @enderror" name="work_end_time" value="{{ old('work_end_time') ?? $barber->work_end_time }}" required>
            @error('work_end_time')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
