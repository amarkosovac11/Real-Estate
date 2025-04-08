<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized access.");
}

include 'db.php';

$property_id = $_GET['id'] ?? null;

if ($property_id && is_numeric($property_id)) {
    $stmt = $conn->prepare("DELETE FROM property WHERE PropertyID = ?");
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
}

header("Location: admin_dashboard.php");
exit();
?>
