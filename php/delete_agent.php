<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized access.");
}

include 'db.php';

$agent_id = $_GET['id'] ?? null;

if ($agent_id) {
    $stmt = $conn->prepare("DELETE FROM agent WHERE AgentID = ?");
    $stmt->bind_param("i", $agent_id);
    $stmt->execute();
}

header("Location: admin_dashboard.php");
exit();
?>
