<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

// ✅ Optional: log file setup
$logPath = __DIR__ . '/logs/debug.log';
function writeLog($msg) {
    global $logPath;
    if (!is_dir(dirname($logPath))) {
        mkdir(dirname($logPath), 0777, true);
    }
    file_put_contents($logPath, date('Y-m-d H:i:s') . " - $msg\n", FILE_APPEND);
}

// ✅ Check if user is logged in and is agent
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'agent') {
    writeLog("Unauthorized delete attempt");
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$agentId = $_SESSION['user_id'];

// ✅ Validate input
$propertyId = $_POST['property_id'] ?? null;
if (!$propertyId || !is_numeric($propertyId)) {
    writeLog("Invalid property_id: $propertyId");
    echo json_encode(['success' => false, 'message' => 'Invalid property ID']);
    exit;
}

// ✅ Check ownership
$stmt = $conn->prepare("SELECT * FROM property WHERE PropertyID = ? AND AgentID = ?");
$stmt->bind_param("ii", $propertyId, $agentId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    writeLog("Property not found or unauthorized access (ID: $propertyId, Agent: $agentId)");
    echo json_encode(['success' => false, 'message' => "Property not found or not owned by you"]);
    exit;
}

// ✅ Delete
$stmt = $conn->prepare("DELETE FROM property WHERE PropertyID = ?");
$stmt->bind_param("i", $propertyId);
$success = $stmt->execute();

if ($success) {
    writeLog("Deleted property ID $propertyId by agent $agentId");
    echo json_encode(['success' => true, 'message' => '✅ Property has been deleted successfully.']);
} else {
    writeLog("Failed to delete property ID $propertyId");
    echo json_encode(['success' => false, 'message' => 'Delete failed']);
}

$conn->close();
