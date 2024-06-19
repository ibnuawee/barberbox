<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekend Finder</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Weekend Finder</h1>
    <form action="/find-weekends" method="POST">
        @csrf
        <div class="form-group">
            <label for="start_date">Tanggal Mulai (YYYY-MM-DD):</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="end_date">Tanggal Akhir (YYYY-MM-DD):</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Cari Akhir Pekan</button>
    </form>

    @if(isset($weekends))
        <h2 class="mt-5">Hasil:</h2>
        <ul class="list-group mt-3">
            @forelse($weekends as $weekend)
                <li class="list-group-item">{{ $weekend }}</li>
            @empty
                <li class="list-group-item">Tidak ada hari Sabtu atau Minggu dalam rentang tanggal yang diberikan.</li>
            @endforelse
        </ul>
    @endif
</div>
</body>
</html>
