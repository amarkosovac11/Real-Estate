<?php
include 'db.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing property ID"]);
    exit;
}

$propertyID = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM property WHERE PropertyID = ?");
$stmt->bind_param("i", $propertyID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $property = $result->fetch_assoc();
    echo json_encode($property);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Property not found"]);
}
?>
