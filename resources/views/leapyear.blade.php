<!DOCTYPE html>
<html>
<head>
    <title>Leap Year Checker</title>
</head>
<body>
    <h1>Leap Year Checker</h1>
    <form action="/check" method="POST">
        @csrf
        <label for="start_year">Start Year:</label>
        <input type="number" id="start_year" name="start_year" required>
        <br>
        <label for="end_year">End Year:</label>
        <input type="number" id="end_year" name="end_year" required>
        <br>
        <button type="submit">Check Leap Years</button>
    </form>

    @if (isset($leapYears))
        <h2>Leap Years between {{ $startYear }} and {{ $endYear }}:</h2>
        <ul>
            @foreach ($leapYears as $year)
                <li>{{ $year }}</li>
            @endforeach
        </ul>
    @endif
</body>
</html>