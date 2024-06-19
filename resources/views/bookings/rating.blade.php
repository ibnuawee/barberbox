@extends('layouts.app')

@section('title', 'Barber Details')

@section('content')
<div class="container">
    <h1>{{ $barber->name }}</h1>
    <p>{{ $barber->description }}</p>

    <h3>Ratings</h3>
    @foreach ($barber->ratings as $rating)
        <div class="rating">
            <strong>{{ $rating->user->name }}</strong>
            <span>{{ $rating->rating }} stars</span>
            <p>{{ $rating->comment }}</p>
        </div>
    @endforeach

        <form action="{{ route('ratings.store') }}" method="POST">
            @csrf
            <input type="hidden" name="barber_id" value="{{ $barber->id }}">
            <div class="form-group">
                <label for="rating">Rating:</label>
                <select name="rating" id="rating" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Rating</button>
        </form>
</div>
@endsection