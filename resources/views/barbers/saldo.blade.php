@extends('layouts.app')

@section('title','List Book')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Riwayat Saldo</h1>
        <div class="section-header-button">
          </div>
    </div>

    <div class="section-body">
        {{-- <h2 class="section-title">Posts</h2>
        <p class="section-lead">
            You can manage all posts, such as editing, deleting and more.
        </p> --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    {{-- <div class="card-header">
                        <h4>All Posts</h4>
                    </div> --}}
                    <div class="card-body">
                        {{-- <div class="float-left">
                            <select class="form-control selectric">
                              <option>Action For Selected</option>
                              <option>Move to Draft</option>
                              <option>Move to Pending</option>
                              <option>Delete Pemanently</option>
                            </select>
                          </div> --}}
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
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Balance Before</th>
                                    <th>Balance After</th>
                                
                                @forelse ($transactions as $index => $transaction)
                                <tr>
                                    <td>{{ $index + $transactions -> firstItem() }}</td>
                                    <td>{{ ucfirst($transaction->type) }}</td>
                                    <td>
                                        <h1 class="badge badge-success">
                                        +{{ $transaction->amount }}
                                        </h1>
                                    </td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ $transaction->created_at }}</td>
                                    <td>{{ $transaction->balance_before }}</td>
                                    <td>{{ $transaction->balance_after }}</td>
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
                                            Riwayat saldo belum tersedia
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
                                    {{$transactions->withQueryString()->links()}}
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
