@extends('layouts.app')

@section('title', 'Barber Details')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $barber->name }}</h1>
    </div>

    <div class="section-body">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Barber Description</h4>
                    </div>
                    <div class="card-body">
                        <p>{{ $barber->description }}</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Ratings</h4>
                    </div>
                    <div class="card-body">
                        @foreach ($barber->ratings as $rating)
                            <div class="rating mb-3">
                                <strong>{{ $rating->user->name }}</strong>
                                <span>{{ $rating->rating }} stars</span>
                                <p>{{ $rating->comment }}</p>
                            </div>
                        @endforeach

                        @auth
                            <form action="{{ url('/ratings') }}" method="POST">
                                @csrf
                                <input type="hidden" name="barber_id" value="{{ $barber->id }}">
                                <div class="form-group">
                                    <label for="rating">Rating:</label>
                                    <select name="rating" id="rating" class="form-control" required>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="comment">Comment:</label>
                                    <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Rating</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('sidebar')
    @parent
    <li class="menu-header">Barber Menu</li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cut"></i>
            <span>Services</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('services.index') }}">View Services</a></li>
            <li><a class="nav-link" href="{{ route('services.create') }}">Add Service</a></li>
        </ul>
    </li>
@endsection