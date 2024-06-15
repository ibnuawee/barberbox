@extends('layouts2.app')

@section('title','User')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>My Booking</h1>
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
                                
                                @forelse ($mybookings as $index => $mybooking)
                                <tr>
                                    <td>
                                        {{$index + $mybookings->firstItem()}}
                                    </td>
                                    <td>
                                        <a href="{{route('booking.show', $mybooking->id)}}">{{$mybooking->invoice_number}}</a>
                                    </td>
                                    <td>
                                        {{$mybooking->user->name}}
                                    </td>
                                    <td>
                                        {{$mybooking->haircut_name}}
                                    </td>
                                    <td>
                                        {{$mybooking->gender}}
                                    </td>
                                    <td>
                                        {{$mybooking->booking_date}}
                                    </td>
                                    <td>
                                        {{$mybooking->status}}
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
                                    {{$mybookings->withQueryString()->links()}}
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