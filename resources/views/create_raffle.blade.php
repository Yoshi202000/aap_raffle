<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Raffle</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 20px;
      background-color: #f5f5f5;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      color: #333;
      margin-bottom: 30px;
      text-align: center;
    }
    form {
      margin-bottom: 20px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="date"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 16px;
    }
    button {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 12px 20px;
      cursor: pointer;
      border-radius: 4px;
      font-size: 16px;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #45a049;
    }
    .table-container {
      margin-top: 30px;
      overflow-x: auto;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #f2f2f2;
    }
    tr:hover {
      background-color: #f5f5f5;
    }
    .action-buttons {
      display: flex;
      gap: 10px;
    }
    .btn-start {
      background-color: #2196F3;
    }
    .btn-start:hover {
      background-color: #0b7dda;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Create a New Raffle</h1>

    <form method="POST" action="{{ url('/raffles') }}">
      @csrf 

      <div class="form-group">
        <label for="raffle_name">Raffle Name:</label>
        <input type="text" id="raffle_name" name="raffle_name" required>
      </div>

      <div class="form-group">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>
      </div>

      <div class="form-group">
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>
      </div>

      <button type="submit">Create Raffle</button>
    </form>

    <div class="table-container">
      <h2>Your Raffles</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($raffles as $raffle)
          <tr>
            <td>{{ $raffle->raffle_id }}</td>
            <td>{{ $raffle->raffle_name }}</td>
            <td>{{ $raffle->start_date }}</td>
            <td>{{ $raffle->end_date }}</td>
            <td class="action-buttons">
              <a href="{{ url('/raffles/' . $raffle->raffle_id . '/edit') }}">
                <button>Edit</button>
              </a>
              <a href="{{ url('/raffles/' . $raffle->raffle_id) }}">
                <button class="btn-start">Start Raffle</button>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>