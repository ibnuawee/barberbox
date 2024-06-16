@extends('layouts2.app')

@section('title','Edit Profile')

@section('content')
<section class="section">
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row mt-sm-4">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="bg-secondary p-5">
                        <div class="profile-widget-header">
                            <img src="{{ auth()->user()->profile ? asset('storage/' . auth()->user()->profile) : asset('assets/img/avatar/avatar-1.png') }}" alt="image" 
                                class="rounded-circle profile-widget-picture" width="150" id="profilePicture" style="cursor: pointer;">
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">{{auth()->user()->name}}
                                <div class="text-muted d-inline font-weight-normal">
                                    <div class="slash"></div>{{auth()->user()->role}}
                                </div>
                            </div>
                            {{auth()->user()->bio}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="bg-secondary p-5">
                        <p class="d-inline-block bg-dark text-primary py-1 px-4">Contact Us</p>
                        <h1 class="text-uppercase mb-4">Have Any Query? Please Contact Us!</h1>
                        <p class="mb-4">The contact form is currently inactive. Get a functional and working contact form with Ajax & PHP in a few minutes. Just copy and paste the files, add a little code and you're done. <a href="https://htmlcodex.com/contact-form">Download Now</a>.</p>
                        <form method="POST" action="{{route('user-profile-information.update')}}" class="needs-validation" novalidate="">
                            @method('PUT')
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        
                                        <input name="name" type="text" class="form-control bg-transparent @error('name', 'updateProfileInformation') is-invalid @enderror" value="{{auth()->user()->name}}">
                                            @error('name', 'updateProfileInformation')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <label>Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                            <input name="email" type="email" class="form-control bg-transparent @error('email', 'updateProfileInformation') is-invalid @enderror" value="{{auth()->user()->email}}" required="">
                                            @error('email', 'updateProfileInformation')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <label>Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                            <input name="phone" type="tel" class="form-control bg-transparent @error('phone', 'updateProfileInformation') is-invalid @enderror" value="{{auth()->user()->phone}}">
                                            @error('phone', 'updateProfileInformation')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <label>Phone</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                            <textarea
                                                name="bio" class="form-control bg-transparent summernote-simple @error('bio', 'updateProfileInformation') is-invalid @enderror" style="height: 100px">
                                                {{auth()->user()->bio}}
                                            </textarea>
                                            @error('bio', 'updateProfileInformation')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <label>Bio</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Change Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <br>
                    <div class="bg-secondary p-5">
                        <form method="POST" action="{{route('user-password.update')}}" class="needs-validation" novalidate="">
                            @method('PUT')
                            @csrf
                            <div class="card-header">
                                <h4>Edit Password</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="current_password">Current Password</label>
                                        <input id="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" name="current_password" tabindex="2">
                                        @error('current_password', 'updatePassword')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label for="password">New Password</label>
                                        <input id="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" name="password" tabindex="2">
                                        @error('password', 'updatePassword')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label for="password_confirmation">Password Confirmation</label>
                                        <input id="password_confirmation" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" name="password_confirmation" tabindex="2">
                                        @error('password_confirmation', 'updatePassword')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary w-100 py-3" type="submit">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Modal for Uploading New Profile Picture -->
<div class="modal fade" id="profilePictureModal" tabindex="-1" role="dialog" aria-labelledby="profilePictureModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profilePictureModalLabel">Change Profile Picture</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('profile.updatePicture') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="profilePictureInput">Choose a new profile picture</label>
                        <input type="file" class="form-control" id="profilePictureInput" name="profile">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('customCss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css">
@endpush

@push('customJs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#profilePicture').click(function(){
                $('#profilePictureModal').modal('show');
            });
        });
    </script>
@endpush
