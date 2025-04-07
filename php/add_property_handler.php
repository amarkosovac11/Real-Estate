<?php
session_start();
include 'db.php';


// Debugging: Check if the session variables are set correctly
echo "Session role: " . $_SESSION['role'];  // Debugging line
echo "Session agent_id: " . $_SESSION['agent_id'];  // Debugging line

// ✅ Make sure an agent is logged in and agent_id is available
if (!isset($_SESSION['agent_id']) || $_SESSION['role'] !== 'agent') {
    die("❌ Unauthorized access. Session role: " . $_SESSION['role'] . " | Session agent_id: " . $_SESSION['agent_id']);
}

$agentID = $_SESSION['agent_id'];  // ✅ Correct session key for agent ID

// ✅ Collect form inputs safely
$address = $_POST['address'] ?? '';
$type = $_POST['type'] ?? '';
$size = $_POST['size'] ?? '';
$price = $_POST['price'] ?? '';
$status = $_POST['status'] ?? 'For Sale';

// ✅ Handle image upload
$imagePath = 'uploads/default.jpg'; // fallback image

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // create the uploads folder if needed
    }

    $fileName = uniqid() . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $imagePath = $targetFile;
    }
}

// ✅ Insert into property table (no AgentID here)
$stmt = $conn->prepare("INSERT INTO property (Address, Type, Size, Price, Status, ImageURL) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssdss", $address, $type, $size, $price, $status, $imagePath);

if ($stmt->execute()) {
    $propertyID = $stmt->insert_id;

    // ✅ Insert into listing table to associate agent with property
    $stmt2 = $conn->prepare("INSERT INTO listing (PropertyID, AgentID, ListingDate) VALUES (?, ?, CURDATE())");
    $stmt2->bind_param("ii", $propertyID, $agentID);
    $stmt2->execute();

    // ✅ Success – redirect
    header("Location: index.php?success=property_added");
    exit();
} else {
    echo "❌ Error adding property: " . $stmt->error;
}
?>
