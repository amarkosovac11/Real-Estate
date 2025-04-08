<?php
session_start();


echo "<pre>";
print_r($_SESSION);
echo "</pre>";


include 'db.php';

// ✅ Role check
$role = $_SESSION['role'] ?? '';
$agentID = $_SESSION['agent_id'] ?? null;
$ownerID = $_SESSION['owner_id'] ?? null;


if (!in_array($role, ['agent', 'owner'])) {
    die("❌ Access denied. Only agents or owners can add properties.");
}

// Check if correct ID is set
if ($role === 'agent') {
    if (!$agentID) {
        die("❌ Unauthorized: Missing agent ID.");
    }
} elseif ($role === 'owner') {
    if (!$ownerID) {
        die("❌ Unauthorized: Missing owner ID.");
    }
}


// ✅ Form data
$address = $_POST['address'] ?? '';
$type = $_POST['type'] ?? '';
$size = $_POST['size'] ?? '';
$price = $_POST['price'] ?? '';
$status = $_POST['status'] ?? 'For Sale';

// ✅ Image upload
$imagePath = 'uploads/default.jpg';

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = uniqid() . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $imagePath = $targetFile;
    }
}

// ✅ Build insert query
if ($role === 'agent') {
    $stmt = $conn->prepare("INSERT INTO property (AgentID, Address, Type, Size, Price, Status, ImageURL) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssdss", $agentID, $address, $type, $size, $price, $status, $imagePath);
} else {
    $stmt = $conn->prepare("INSERT INTO property (OwnerID, Address, Type, Size, Price, Status, ImageURL) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssdss", $ownerID, $address, $type, $size, $price, $status, $imagePath);
}

if ($stmt->execute()) {
    $propertyID = $conn->insert_id;

    // ✅ Insert into listing table if agent
    if ($role === 'agent') {
        $stmtListing = $conn->prepare("INSERT INTO listing (PropertyID, AgentID) VALUES (?, ?)");
        $stmtListing->bind_param("ii", $propertyID, $agentID);
        $stmtListing->execute();
    }

    header("Location: index.php?success=property_added");
    exit();
} else {
    echo "❌ Error adding property: " . $stmt->error;
}


?>
