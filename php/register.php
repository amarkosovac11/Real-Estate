<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
</head>
<body>
<h2>Register</h2>
<form action="register_handler.php" method="POST">
  <label>Name:</label>
  <input type="text" name="name" required><br>

  <label>Username:</label>
  <input type="text" name="username" required><br>

  <label>Password:</label>
  <input type="password" name="password" required><br>

  <label>Contact Info:</label>
  <input type="text" name="contact" required><br>

  <label>Register as:</label>
  <select name="role" required>
    <option value="client">Client</option>
    <option value="agent">Agent</option>
  </select><br><br>

  <button type="submit">Register</button>
</form>
<p>Already have an account? <a href="login.php">Log in here</a></p>
</body>
</html>
