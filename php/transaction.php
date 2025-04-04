<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    die("Access denied. Please log in as a client.");
}

$clientID = $_SESSION['user_id'];
$propertyID = $_GET['property_id'] ?? null;
$action = $_GET['action'] ?? null;

if (!$propertyID || !$action || !in_array($action, ['Rent', 'Sale'])) {
    die("Invalid request.");
}

// Get property details
$stmt = $conn->prepare("SELECT * FROM property WHERE PropertyID = ?");
$stmt->bind_param("i", $propertyID);
$stmt->execute();
$property = $stmt->get_result()->fetch_assoc();

// Get agent listing for that property
$stmt = $conn->prepare("SELECT agent.AgentID, agent.Name FROM listing JOIN agent ON listing.AgentID = agent.AgentID WHERE listing.PropertyID = ?");
$stmt->bind_param("i", $propertyID);
$stmt->execute();
$agentResult = $stmt->get_result();
$agent = $agentResult->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title><?= htmlspecialchars($action) ?> Property</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
    }
    form {
      margin-top: 20px;
    }
    label {
      display: block;
      margin-top: 10px;
    }
    input[type="date"] {
      padding: 5px;
    }
    button {
      margin-top: 15px;
      padding: 8px 16px;
    }
  </style>
</head>
<body>
  <h2><?= htmlspecialchars($action) ?> Property</h2>

  <form action="process_transaction.php" method="POST">
    <input type="hidden" name="property_id" value="<?= $propertyID ?>">
    <input type="hidden" name="action" value="<?= $action ?>">
    <input type="hidden" name="client_id" value="<?= $clientID ?>">
    <input type="hidden" name="agent_id" value="<?= $agent ? $agent['AgentID'] : 1 ?>"> <!-- fallback -->

    <p><strong>Property:</strong> <?= htmlspecialchars($property['Address']) ?></p>
    <p><strong>Price:</strong> $<?= number_format($property['Price'], 2) ?></p>
    <p><strong>Agent:</strong> <?= $agent ? htmlspecialchars($agent['Name']) : 'No agent assigned' ?></p>

    <?php if ($action === 'Rent'): ?>
      <label>Start Date:</label>
      <input type="date" name="start_date" required>

      <label>End Date:</label>
      <input type="date" name="end_date" required>
    <?php endif; ?>

    <button type="submit">Confirm <?= htmlspecialchars($action) ?></button>
  </form>

  <br><a href="index.php">Cancel</a>
</body>
</html>
