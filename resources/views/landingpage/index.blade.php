@extends('layouts2.app')

@section('banner')
    @include('layouts2.banner')
@endsection
@section('content')
    @include('layouts2.about')
    <br><br>
    @include('layouts2.service')
    <br><br>
    @include('layouts2.price')
    <br><br>
    @include('layouts2.team')
    <br><br>
    @include('layouts2.working')
    <br><br>
    @include('layouts2.testimoni')
@endsection