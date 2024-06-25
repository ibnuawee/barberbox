@extends('layouts.app')

@section('title','Jadwal')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Atur Jadwal</h1>
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
                        <div class="float-left">
                                <form action="{{ route('barber.setSchedule') }}" method="POST">
                                @csrf
                                    <label for="available_date">Tambah Jadwal:</label>
                                    <input type="datetime-local" name="available_date" id="available_date" required>
                                    <button type="submit">Set</button>
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
                                    <th>Jadwal Tersedia</th>
                                    <th>Aksi</th>
                                
                                @forelse ($schedules as $index => $schedule)
                                <tr>
                                    <td>
                                        {{$index + $schedules->firstItem()}}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($schedule->available_date)->locale('id')->translatedFormat('l, d F Y H:i') }}
                                    </td>
                                    <td>
                                        <form action="{{route('schedule.destroy', $schedule->id)}}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td>
                                            Jadwal Kosong
                                        </td>
                                    </tr>
                                @endforelse
                                
                            </table>
                        </div>
                        <div class="float-right">
                            <nav>
                                <ul class="pagination">
                                    {{$schedules->withQueryString()->links()}}
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
