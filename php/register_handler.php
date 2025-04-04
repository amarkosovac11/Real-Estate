<?php
include 'db.php';

$name = $_POST['name'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$contact = $_POST['contact'];
$role = $_POST['role'];

if ($role == 'client') {
    $sql = "INSERT INTO client (Name, ContactInfo, ClientType, username, password)
            VALUES (?, ?, 'Buyer', ?, ?)";
} else {
    $sql = "INSERT INTO agent (Name, ContactInfo, username, password)
            VALUES (?, ?, ?, ?)";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $contact, $username, $password);

if ($stmt->execute()) {
    echo "✅ Registration successful. <a href='login.php'>Log in</a>";
} else {
    echo "❌ Registration failed: " . $conn->error;
}
?>
