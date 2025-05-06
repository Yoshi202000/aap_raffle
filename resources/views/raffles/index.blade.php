<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Raffles</title> {{-- Generic title for the list --}}
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
    }
    .raffle-card {
      background-color: #f9f9f9;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 6px;
      border: 1px solid #ddd;
    }
    .raffle-card h2 {
      margin-top: 0;
    }
    .raffle-card a {
      color: #3490dc;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>List of Raffles</h1>

    @if(count($raffles))
      @foreach($raffles as $raffle)
        <div class="raffle-card">
          <h2>{{ $raffle->raffle_name }}</h2>
          <p><strong>Start:</strong> {{ $raffle->start_date }}</p>
          <p><strong>End:</strong> {{ $raffle->end_date }}</p>
          <a href="{{ url('/raffles/' . $raffle->raffle_id . '/edit') }}">View/Edit Raffle</a><br>
          <a href="{{ url('raffles/' . $raffle->raffle_id) }}">Start Raffle</a>
          </div>
      @endforeach
    @else
      <p>No raffles available.</p>
    @endif
  </div>
</body>
</html>
