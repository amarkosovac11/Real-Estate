<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5" style="max-width: 500px;">
  <h2 class="text-center mb-4">Register</h2>
  
  <form action="register_handler.php" method="POST">
    <div class="mb-3">
      <label for="name" class="form-label">Full Name:</label>
      <input type="text" id="name" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="username" class="form-label">Username:</label>
      <input type="text" id="username" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password:</label>
      <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="contactInfo" class="form-label">Contact Info:</label>
      <input type="text" id="contactInfo" name="contactInfo" class="form-control" required>
    </div>

    <div class="mb-4">
      <label for="role" class="form-label">Register as:</label>
      <select id="role" name="role" class="form-select" required>
        <option value="client">Client</option>
        <option value="agent">Agent</option>
        <option value="owner">Property Owner</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary w-100">Register</button>
  </form>

  <p class="text-center mt-3">
    Already have an account? <a href="login.php">Log in here</a>
  </p>
</div>

</body>
</html>
