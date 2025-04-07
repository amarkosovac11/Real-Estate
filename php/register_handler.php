<?php
include 'db.php';

$name = $_POST['name'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$contact = $_POST['contact'];
$role = $_POST['role'];

// ✅ Prvo provjeri da li korisničko ime već postoji
$table = $role === 'client' ? 'client' : 'agent';

$check_sql = "SELECT * FROM $table WHERE username = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $username);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    echo "❌ Username already exists. Please try another one.";
    echo "<br><a href='register.php'>Go back</a>";
    exit();
}

// ✅ Nastavi s upisom ako je sve ok
if ($role === 'client') {
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