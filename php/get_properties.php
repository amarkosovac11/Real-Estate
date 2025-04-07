<?php
include 'db.php';

// Change status to 'For sale' or 'For rent' based on what you're looking for
$sql = "SELECT p.PropertyID, p.Address, p.Type, p.Size, p.Price, p.Status, p. ImageURL
        FROM property p
        WHERE p.Status IN ('For sale', 'For rent')";
$result = $conn->query($sql);

$properties = [];
while ($row = $result->fetch_assoc()) {
    $properties[] = $row;
}

echo json_encode($properties);
?>
