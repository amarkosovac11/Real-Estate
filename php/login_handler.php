<?php
session_start();
include 'db.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

if ($role !== 'agent' && $role !== 'client') {
    die("❌ Invalid role selected.");
}

$table = $role === 'agent' ? 'agent' : 'client';
$id_column = $role === 'agent' ? 'AgentID' : 'ClientID';

// Prepare and execute query
$sql = "SELECT * FROM $table WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        // ✅ SESSION SETUP
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $role;
        $_SESSION['user_id'] = $user[$id_column];

        if ($role === 'agent') {
            $_SESSION['agent_id'] = $user['AgentID'];
        } else {
            $_SESSION['client_id'] = $user['ClientID'];
        }

        // ✅ DEBUG PRINT
        echo "<pre>Session set:\n";
        print_r($_SESSION);
        echo "</pre><a href='index.php'>Continue</a>";

        exit();
    }
}

echo "❌ Login failed. Invalid username or password.<br>";
echo "<a href='login.php'>Try again</a>";
?>