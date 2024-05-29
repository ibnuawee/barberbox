@extends('layouts.app')

@section('title','Tambah User')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{route('user.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
          </div>
        <h1>Tambah User</h1>
    </div>

    <div class="section-body">
        <div class="row mt-sm-4">
            
            <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                    <form method="POST" action="{{route('user.store')}}" class="needs-validation" novalidate="">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="name">Nama</label>
                                    <input name="name" type="text" id="name" class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label for="email">Email</label>
                                    <input name="email" type="email" id="email" class="form-control @error('email',) is-invalid @enderror">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="phone">Nomor Hp</label>
                                    <input name="phone" type="tel" id="phone" class="form-control @error('phone') is-invalid @enderror">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label for="password">Password</label>
                                    <input name="password" type="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input name="password_confirmation" type="password" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="user">User</option>
                                    <option value="barber">Barber</option>
                                </select>
                            </div>
                    

                            {{-- <div class="mb-3">
                                <label for="email_verified_at" class="form-label">Verified</label>
                                <select name="email_verified_at" id="email_verified_at" class="form-select" required>
                                    <option value="email_verified_at">Yes</option>
                                </select>
                            </div> --}}

                            <div class="mb-3">
                                <label for="email_verified_at" class="form-label">Verified</label>
                                <select name="email_verified_at" id="email_verified_at" class="form-select">
                                    <option value="email_verified_at">Yes</option>
                                </select>
                            </div>
                    
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit">Change Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('sidebar')
@parent
<li class="menu-header">Starter</li>
<li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
        <span>Layout</span></a>
    <ul class="dropdown-menu">
        <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
        <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
        <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
    </ul>
</li>

@endsection

@push('customCss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css">
@endpush

@push('customJs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>
@endpush