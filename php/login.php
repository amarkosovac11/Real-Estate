<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>
<h2>Login</h2>
<form action="login_handler.php" method="POST">
  <label>Username:</label>
  <input type="text" name="username" required><br>

  <label>Password:</label>
  <input type="password" name="password" required><br>

  <label>Role:</label>
  <select name="role" required>
    <option value="client">Client</option>
    <option value="agent">Agent</option>
  </select><br><br>

  <button type="submit">Login</button>
</form>
<p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
