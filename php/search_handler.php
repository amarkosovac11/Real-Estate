<?php
header('Content-Type: application/json');
include 'db.php';

$address = $_POST['address'] ?? '';
$type = $_POST['type'] ?? '';
$price = $_POST['price'] ?? '';

// Start query
$query = "SELECT * FROM property WHERE 1=1";
$params = [];
$types = "";

// Add filters only if values are provided
if (!empty($address)) {
    $query .= " AND Address LIKE ?";
    $params[] = "%$address%";
    $types .= "s";
}

if (!empty($type)) {
    $query .= " AND Type = ?";
    $params[] = $type;
    $types .= "s";
}

if (!empty($price)) {
    if ($price === "200000") {
        $query .= " AND Price >= ?";
        $params[] = 200000;
        $types .= "d";
    } else {
        [$min, $max] = explode('-', $price);
        $query .= " AND Price BETWEEN ? AND ?";
        $params[] = (float)$min;
        $params[] = (float)$max;
        $types .= "dd";
    }
}

$stmt = $conn->prepare($query);

// Only bind if there are parameters
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Format results
$properties = [];
while ($row = $result->fetch_assoc()) {
    $properties[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($properties);
