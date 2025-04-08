<?php
include 'db.php';
session_start();

$properties = [];

if (isset($_SESSION['role']) && $_SESSION['role'] === 'owner') {
    $owner_id = $_SESSION['user_id'];

    $sql = "SELECT p.PropertyID, p.Address, p.Type, p.Size, p.Price, p.Status, p.ImageURL
            FROM property p
            WHERE p.Status IN ('For sale', 'For rent') AND p.OwnerID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $owner_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $properties[] = $row;
    }

    $stmt->close();
} else {
    // For admins or other roles: show all
    $sql = "SELECT p.PropertyID, p.Address, p.Type, p.Size, p.Price, p.Status, p.ImageURL
            FROM property p
            WHERE p.Status IN ('For sale', 'For rent')";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $properties[] = $row;
    }
}

echo json_encode($properties);
?>
