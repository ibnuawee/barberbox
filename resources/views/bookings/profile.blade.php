@extends('layouts2.app')

@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-md-4">
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
                    <p class="proile-rating">RATINGS : <span>8.7/10</span></p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false">Services</a>
                            </li>
                        </ul>
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
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
                                <!-- Display services here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
