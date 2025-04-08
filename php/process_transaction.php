<?php
session_start();
include 'db.php';

echo "AgentID: " . $agentID . "<br>";


$propertyID = $_POST['property_id'];
$clientID = $_POST['client_id'];
$agentID = $_POST['agent_id'];
$action = $_POST['action'];
$finalPrice = 0;

$stmt = $conn->prepare("SELECT Price FROM property WHERE PropertyID = ?");
$stmt->bind_param("i", $propertyID);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$finalPrice = $result['Price'];

// Insert transaction
$stmt = $conn->prepare("INSERT INTO transaction (PropertyID, ClientID, AgentID, Type, FinalPrice) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iiisd", $propertyID, $clientID, $agentID, $action, $finalPrice);
$stmt->execute();
$transactionID = $stmt->insert_id;

// If it's a rent, insert into rentaldetails
if ($action === 'Rent') {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    $stmt = $conn->prepare("INSERT INTO rentaldetails (TransactionID, StartDate, EndDate) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $transactionID, $startDate, $endDate);
    $stmt->execute();
}

// Update property status
$newStatus = $action === 'Rent' ? 'Rented' : 'Sold';
$stmt = $conn->prepare("UPDATE property SET Status = ? WHERE PropertyID = ?");
$stmt->bind_param("si", $newStatus, $propertyID);
$stmt->execute();

header("Location: index.php?success=1");
exit();
?>
