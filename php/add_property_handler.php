<?php
session_start();
include 'db.php';

// Check if agent is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'agent') {
    die("Unauthorized access.");
}

$agentID = $_SESSION['user_id'];

// Get form data
$address = $_POST['address'];
$type = $_POST['type'];
$size = $_POST['size'];
$price = $_POST['price'];
$status = $_POST['status'];

// ======================
// ✅ Handle Image Upload
// ======================
$imagePath = 'uploads/default.jpg'; // fallback image

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $targetDir = "uploads/";
    $fileName = uniqid() . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $fileName;

    // Move file from temp location to uploads folder
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $imagePath = $targetFile;
    }
}

// ======================
// ✅ Insert into property
// ======================
$stmt = $conn->prepare("INSERT INTO property (Address, Type, Size, Price, Status, ImageURL) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssdss", $address, $type, $size, $price, $status, $imagePath);

if ($stmt->execute()) {
    $propertyID = $stmt->insert_id;

    // =========================
    // ✅ Insert into listing
    // =========================
    $stmt2 = $conn->prepare("INSERT INTO listing (PropertyID, AgentID, ListingDate) VALUES (?, ?, CURDATE())");
    $stmt2->bind_param("ii", $propertyID, $agentID);
    $stmt2->execute();

    // ✅ Redirect back with success
    header("Location: index.php?success=property_added");
    exit();
} else {
    echo "Error adding property: " . $stmt->error;
}
?>
