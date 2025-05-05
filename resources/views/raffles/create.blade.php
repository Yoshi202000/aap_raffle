<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Raffle</title>
</head>
<body>
  <h1>Create a New Raffle</h1>

  <form method="POST" action="{{ url('/raffles') }}" enctype="multipart/form-data" onsubmit="return validateImage()">
  @csrf

    <label for="raffle_name">Raffle Name:</label>
    <input type="text" id="raffle_name" name="raffle_name" required><br><br>

    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required><br><br>

    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" required><br><br>

    <label for="bg_image">Background Image:</label>
    <input type="file" id="bg_image" name="bg_image" accept="image/*"><br><br>

    <button type="submit">Create Raffle</button>
  </form>
</body>
<script>
function validateImage() {
  const fileInput = document.getElementById('bg_image');
  const file = fileInput.files[0];

  if (file) {
    const validTypes = ['image/png'];
    if (!validTypes.includes(file.type)) {
      alert('Only image files png files are allowed.');
      fileInput.value = '';
      return false; 
    }
  }

  return true; 
}
</script>
</html>
