<?php
session_start();
include 'db.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

if (!in_array($role, ['agent', 'client', 'admin', 'owner'])) {
    die("❌ Invalid role selected.");
}

switch ($role) {
    case 'agent':
        $table = 'agent';
        $id_column = 'AgentID';
        break;
    case 'client':
        $table = 'client';
        $id_column = 'ClientID';
        break;
    case 'admin':
        $table = 'admin';
        $id_column = 'AdminID';
        break;
    case 'owner':
        $table = 'owner';
        $id_column = 'OwnerID';
        break;
}

$sql = "SELECT * FROM $table WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if ($user['password'] === md5($password)) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $role;
        $_SESSION['user_id'] = $user[$id_column];

        // Optional role-specific session variables
        if ($role === 'agent') {
            $_SESSION['agent_id'] = $user['AgentID'];
            header("Location: home.php");
        } elseif ($role === 'owner') {
            $_SESSION['owner_id'] = $user['OwnerID'];
            header("Location: home.php"); // or 'owner_dashboard.php'
        } elseif ($role === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: home.php");
        }
        exit();
    }
}

echo "❌ Login failed. Invalid username or password.<br>";
echo "<a href='login.php'>Try again</a>";
?>
