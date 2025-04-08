<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized access.");
}

include 'db.php';

$client_id = $_GET['id'] ?? null;

if ($client_id) {
    $stmt = $conn->prepare("DELETE FROM client WHERE ClientID = ?");
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
}

header("Location: admin_dashboard.php");
exit();
?>
