<?php 
include 'db.php';

$name = $_POST['name'] ?? '';
$username = $_POST['username'] ?? '';
$contactInfo = $_POST['contactInfo'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? 'client';

if (empty($name) || empty($username) || empty($contactInfo) || empty($password)) {
    die("❌ All fields are required.");
}

if (!in_array($role, ['client', 'agent', 'owner'])) {
    die("❌ Invalid role selected.");
}

$hashedPassword = md5($password);

// Prepare SQL and bind
if ($role === 'agent') {
    $sql = "INSERT INTO agent (Name, username, ContactInfo, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $username, $contactInfo, $hashedPassword);
} elseif ($role === 'owner') {
    $sql = "INSERT INTO owner (Name, username, ContactInfo, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $username, $contactInfo, $hashedPassword);
} else { // client
    $sql = "INSERT INTO client (Name, username, ContactInfo, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $username, $contactInfo, $hashedPassword);
}

// Execute
if ($stmt->execute()) {
    echo "✅ Registration successful. <a href='login.php'>Login now</a>";
} else {
    echo "❌ Error: " . $conn->error;
}
?>
