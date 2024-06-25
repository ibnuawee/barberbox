@extends('layouts2.app')

@section('content')
<style>
    .nav-tabs .nav-link.active {
        background-color: transparent;
        color: #ffc107;
        border-color: #ffc107;
    }
    .nav-tabs .nav-link {
        color: #ff0000;
    }
    .nav-tabs .nav-link:hover {
        color: #ffc107;
    }
    .profile-head h5, .profile-head h6 {
        font-weight: bold;
    }
    .profile-head .proile-rating span {
        font-size: 1.5rem;
        color: #ffc107;
    }
    .list-group-item {
        background-color: #343a40;
        border: none;
        margin-bottom: 10px;
        border-radius: 10px;
        padding: 15px;
        transition: background-color 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .list-group-item:hover {
        background-color: #495057;
    }
    .list-group-item strong {
        font-size: 1.2rem;
        color: #ffc107;
    }
    .list-group-item p {
        margin: 0;
        font-size: 1rem;
        color: #f8f9fa;
    }
    .profile-img img {
        border-radius: 50%;
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 2px solid #ffc107;
    }
    .button .btn {
        width: 100%;
        font-size: 1rem;
    }
    .followers-count {
        font-size: 1.2rem;
        color: #ffc107;
    }
    .stars-outer {
        display: inline-block;
        position: relative;
        font-family: FontAwesome;
    }
    .stars-outer::before {
        content: '\f005 \f005 \f005 \f005 \f005';
        color: #ccc;
        font-family: 'FontAwesome';
    }
    .stars-inner {
        position: absolute;
        top: 0;
        left: 0;
        white-space: nowrap;
        overflow: hidden;
        width: 0;
        color: #ffc107;
    }
    .stars-inner::before {
        content: '\f005 \f005 \f005 \f005 \f005';
        font-family: 'FontAwesome';
    }
    .rating-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>
<div class="container">
    <div class="row py-5">
        <div class="col-md-4 text-center">
            <div class="profile-img">
                <img src="{{ asset('storage/' . $barber->user->profile) }}" alt="Profile Image" class="img-fluid">
            </div>
            <div class="mt-3">
                <h4>{{ $barber->user->name }}</h4>
                <p class="text-secondary mb-1">{{ $barber->user->email }}</p>
                <p class="text-muted font-size-sm">{{ $barber->address }}</p>
                <div class="followers">
                    <strong class="followers-count">{{ $barber->followers_count }}</strong> Followers
                </div>
                <div class="button my-3">
                    @if(auth()->check() && auth()->user()->following->contains('barber_id', $barber->id))
                        <form action="{{ route('unfollow.barber', $barber->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Unfollow</button>
                        </form>
                    @else
                        <form action="{{ route('follow.barber') }}" method="POST">
                            @csrf
                            <input type="hidden" name="barber_id" value="{{ $barber->id }}">
                            <button type="submit" class="btn btn-primary">Follow</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="profile-head">
                <h5>{{ $barber->user->name }}</h5>
                <h6>Professional Barber</h6>
                <p class="proile-rating">RATINGS :
                    <span class="stars-outer">
                        <span class="stars-inner" style="width: {{ ($averageRating / 5) * 100 }}%;"></span>
                    </span>
                    ({{ number_format($averageRating, 1) }})
                </p>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ratings-tab" data-bs-toggle="tab" href="#ratings" role="tab" aria-controls="ratings" aria-selected="false">Ratings</a>
                        </li>
                    </ul>
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>User Id</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $barber->user->id }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Name</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $barber->user->name }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $barber->user->email }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Phone</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $barber->user->phone }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Services and Prices</h5>
                                    <ul class="list-group">
                                        @foreach($barber->services as $service)
                                            <li class="list-group-item">
                                                <div>
                                                    <strong>{{ $service->name }}</strong>
                                                    <span class="text-muted"> - Rp {{ number_format($service->pivot->price, 0, ',', '.') }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ratings" role="tabpanel" aria-labelledby="ratings-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Ratings and Reviews</h5>
                                    <ul class="list-group">
                                        @foreach($barber->ratings as $rating)
                                            <li class="list-group-item">
                                                <div class="rating-item">
                                                    <strong>{{ $rating->user->name }}</strong>
                                                    <span class="stars-outer">
                                                        <span class="stars-inner" style="width: {{ ($rating->rating / 5) * 100 }}%;"></span>
                                                    </span>
                                                </div>
                                                <p>{{ $rating->review }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
