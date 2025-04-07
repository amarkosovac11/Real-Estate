<?php
session_start();
include 'db.php';

// ✅ Debug: prikaz agent_id
var_dump($_SESSION['agent_id']);
echo "Session role: " . $_SESSION['role'];
echo "Session agent_id: " . $_SESSION['agent_id'];

// ✅ Provjera da li je agent ulogovan
if (!isset($_SESSION['agent_id']) || $_SESSION['role'] !== 'agent') {
    die("❌ Unauthorized access. Session role: " . $_SESSION['role'] . " | Session agent_id: " . $_SESSION['agent_id']);
}

$agentID = $_SESSION['agent_id'];

// ✅ Podaci iz forme
$address = $_POST['address'] ?? '';
$type = $_POST['type'] ?? '';
$size = $_POST['size'] ?? '';
$price = $_POST['price'] ?? '';
$status = $_POST['status'] ?? 'For Sale';

// ✅ Upload slike
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

// ✅ Unos u tabelu property, uključujući AgentID
$stmt = $conn->prepare("INSERT INTO property (AgentID, Address, Type, Size, Price, Status, ImageURL) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssdss", $agentID, $address, $type, $size, $price, $status, $imagePath);

if ($stmt->execute()) {
    echo "✅ Property added successfully.";
    header("Location: index.php?success=property_added");
    exit();
} else {
    echo "❌ Error adding property: " . $stmt->error;
}
?>