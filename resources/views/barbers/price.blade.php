@extends('layouts.app')

@section('title','User')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>List User</h1>
    </div>

    <div class="section-body">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Posts</h4>
                    </div>
                    <div class="card-body">
                        <div class="float-left">
                            <form method="POST" action="{{ route('barber.setPrice') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="service_id">Service</label>
                                    <select name="service_id" id="service_id" class="form-control" required>
                                        @foreach($allservices as $allservice)
                                            <option value="{{ $allservice->id }}">{{ $allservice->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" id="price" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Set Price</button>
                            </form>

                          </div>
                        <div class="float-right">
                            <form method="GET">
                                <div class="input-group">
                                    <input name="search" type="text" class="form-control" placeholder="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="clearfix mb-3"></div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>No</th>
                                    <th>Service</th>
                                    <th>Harga</th>
                                
                                @forelse ($services as $index => $service)
                                <tr>
                                    <td>
                                        {{$index + $services->firstItem()}}
                                    </td>
                                    <td>
                                        {{ $service->name }}
                                    </td>
                                    <td>
                                        Rp. {{ $service->pivot->price }}
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td>
                                            Service Kosong
                                        </td>
                                    </tr>
                                @endforelse
                                
                            </table>
                        </div>
                        <div class="float-right">
                            <nav>
                                <ul class="pagination">
                                    {{$services->withQueryString()->links()}}
                                </ul>
                            </nav>
                        </div>
                    </div>
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