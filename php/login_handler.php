<?php
session_start();
include 'db.php';

// Get login input safely
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

// Validate role
if ($role !== 'agent' && $role !== 'client') {
    die("❌ Invalid role selected.");
}

// Determine table and ID column based on role
$table = $role === 'agent' ? 'agent' : 'client';
$id_column = $role === 'agent' ? 'AgentID' : 'ClientID';

// Prepare and execute query
$sql = "SELECT * FROM $table WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    // Check password
    if (password_verify($password, $user['password'])) {
        // ✅ Set session variables
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $role;
        $_SESSION['user_id'] = $user[$id_column]; // Common key for both roles

        if ($role === 'agent') {
            $_SESSION['agent_id'] = $user['AgentID'];
        } else {
            $_SESSION['client_id'] = $user['ClientID'];
        }

        // 🛠 Optional: Debug output
        // echo "✅ Login successful. Role: {$_SESSION['role']}, ID: {$_SESSION['user_id']}";

        // Redirect to home page
        header("Location: index.php");
        exit();
    }
}

// ❌ If login fails
echo "❌ Login failed. Invalid username or password.<br>";
echo "<a href='login.php'>Try again</a>";
?>
