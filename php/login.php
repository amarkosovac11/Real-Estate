<?php include 'header.php'; ?>

<div class="container mt-5" style="max-width: 500px;">
    <h2 class="text-center mb-4">Login</h2>
    <form action="login_handler.php" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-4">
            <label for="role" class="form-label">Login as:</label>
            <select name="role" id="role" class="form-select" required>
                <option value="client">Client</option>
                <option value="agent">Agent</option>
                <option value="admin">Admin</option>
                <option value="owner">Owner</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <p class="text-center mt-3">
        Don't have an account? <a href="register.php">Register here</a>
    </p>
</div>

<?php include 'footer.php'; ?>
