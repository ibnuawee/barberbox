@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Barbers</h1>
    <ul>
        @foreach($barbers as $barber)
            <li>{{ $barber->name }}</li>
        @endforeach
    </ul>
</div>
@endsection
