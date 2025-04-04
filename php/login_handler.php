<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$table = $role === 'agent' ? 'agent' : 'client';
$id_column = $role === 'agent' ? 'AgentID' : 'ClientID';

$sql = "SELECT * FROM $table WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user[$id_column];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $role;

        header("Location: index.php");
        exit();
    }
}

echo "❌ Login failed. <a href='login.php'>Try again</a>";
?>
