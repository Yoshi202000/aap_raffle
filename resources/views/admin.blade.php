<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Raffle</title>
</head>
<body>
  <h1>Create a New Raffle</h1>

  <form method="POST" action="http://localhost:8000/raffles">
    @csrf 

    <label for="raffle_name">Raffle Name:</label>
    <input type="text" id="raffle_name" name="raffle_name" required><br><br>

    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required><br><br>

    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" required><br><br>

    <button type="submit">Create Raffle</button>
  </form>
</body>
</html>
