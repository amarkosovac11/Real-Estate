<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized access.");
}

include 'db.php';

$transaction_id = $_GET['id'] ?? null;

if ($transaction_id) {
    $stmt = $conn->prepare("DELETE FROM transaction WHERE TransactionID = ?");
    $stmt->bind_param("i", $transaction_id);
    $stmt->execute();
}

header("Location: admin_dashboard.php");
exit();
?>
