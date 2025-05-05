<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $raffle->raffle_name }}</title>
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
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      color: #333;
    }
    .raffle-info {
      margin-bottom: 20px;
      padding: 10px;
      background-color: #f5f5f5;
      border-radius: 5px;
    }
    .prize-item {
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    .back-link {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 15px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>{{ $raffle->raffle_name }}</h1>
    
    <div class="raffle-info">
      <p><strong>ID:</strong> {{ $raffle->raffle_id }}</p>
      <p><strong>Start Date:</strong> {{ $raffle->start_date }}</p>
      <p><strong>End Date:</strong> {{ $raffle->end_date }}</p>
    </div>
    
    <h2>Prizes</h2>
    
    @if(count($prizes) > 0)
      @foreach($prizes as $prize)
        <div class="prize-item">
          <h3>{{ $prize->prize_name }}</h3>
          <p><strong>Value:</strong> ${{ number_format($prize->prize_value, 2) }}</p>
          @if(isset($prize->prize_image) && $prize->prize_image)
            <img src="{{ asset($prize->prize_image) }}" alt="{{ $prize->prize_name }}" style="max-width: 200px;">
          @else
            <p>No image available</p>
          @endif
        </div>
      @endforeach
    @else
      <p>No prizes available for this raffle.</p>
    @endif
    
    <a href="{{ url('/raffles') }}" class="back-link">Back to Raffles</a>
  </div>
</body>
</html>