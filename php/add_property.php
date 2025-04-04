<?php
session_start();

// Check if agent is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'agent') {
    die("Access denied. Only agents can add properties.");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Property</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background-color: #f8f9fa;
    }

    .container {
      background: white;
      padding: 30px;
      border-radius: 8px;
      max-width: 600px;
      margin: auto;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Add a New Property</h2>

    <form action="add_property_handler.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>Address:</label>
        <input type="text" name="address" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Type:</label>
        <select name="type" class="form-control" required>
          <option value="Apartment">Apartment</option>
          <option value="House">House</option>
          <option value="Studio">Studio</option>
          <option value="Villa">Villa</option>
        </select>
      </div>

      <div class="form-group">
        <label>Size (in m²):</label>
        <input type="number" name="size" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Price:</label>
        <input type="number" step="0.01" name="price" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Status:</label>
        <select name="status" class="form-control" required>
          <option value="For Sale">For Sale</option>
          <option value="For Rent">For Rent</option>    
        </select>
      </div>

      <div class="form-group">
        <label>Upload Image:</label>
        <input type="file" name="image" accept="image/*" class="form-control-file" required>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Add Property</button>
    </form>

    <div class="text-center mt-4">
      <a href="index.php" class="btn btn-secondary">← Back to Home</a>
    </div>
  </div>

</body>
</html>
