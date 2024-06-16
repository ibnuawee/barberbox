@extends('layouts.app')

@section('title','User')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>List Booking</h1>
        <div class="section-header-button">
          </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Posts</h2>
        <p class="section-lead">
            You can manage all posts, such as editing, deleting and more.
        </p>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Posts</h4>
                    </div>
                    <div class="card-body">
                        <div class="float-left">
                            <select class="form-control selectric">
                              <option>Action For Selected</option>
                              <option>Move to Draft</option>
                              <option>Move to Pending</option>
                              <option>Delete Pemanently</option>
                            </select>
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
                                    <th>Invoice</th>
                                    <th>Nama</th>
                                    <th>Hair Style</th>
                                    <th>Gender</th>
                                    <th>Tanggal Booking</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                
                                @forelse ($bookings as $index => $booking)
                                <tr>
                                    <td>
                                        {{$index + $bookings->firstItem()}}
                                    </td>
                                    <td>
                                        {{$booking->invoice_number}}
                                    </td>
                                    <td>{{$booking->user->name}}
                                        <div class="table-links">
                                            <div class="bullet"></div>
                                            <a href="">Edit</a>
                                            <div class="bullet"></div>
                                        </div>
                                    </td>
                                    <td>
                                        {{$booking->haircut_name}}
                                    </td>
                                    <td>
                                        {{$booking->gender}}
                                    </td>
                                    <td>
                                        {{$booking->booking_date}}
                                    </td>
                                    <td>
                                        {{$booking->status}}
                                    </td>
                                    <td>
                                        @if ($booking->status === 'pending')
                                            <form action="{{ route('booking.accept', $booking->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Confirm</button>
                                            </form>
                                        @elseif ($booking->status === 'pending' || $booking->status === 'confirmed')
                                            <form action="{{ route('booking.complete', $booking->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Complete</button>
                                            
                                            </form>
                                            <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Cancel</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td>
                                            
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td style="text-align: center;">
                                            Data booking belum tersedia
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                @endforelse
                                
                            </table>
                        </div>
                        <div class="float-right">
                            <nav>
                                <ul class="pagination">
                                    {{$bookings->withQueryString()->links()}}
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