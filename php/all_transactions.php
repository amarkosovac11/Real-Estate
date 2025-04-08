<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'agent') {
    die("Access denied. Only agents can view this page.");
}

$agentID = $_SESSION['user_id'];

// Fetch all transactions this agent is part of
$sql = "SELECT 
            t.TransactionID,
            t.Type,
            t.TransactionDate,
            t.FinalPrice,
            p.Address,
            p.Type AS PropertyType,
            c.Name AS ClientName,
            r.StartDate,
            r.EndDate
        FROM transaction t
        JOIN property p ON t.PropertyID = p.PropertyID
        JOIN client c ON t.ClientID = c.ClientID
        LEFT JOIN rentaldetails r ON t.TransactionID = r.TransactionID
        WHERE t.AgentID = ?
        ORDER BY t.TransactionDate DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $agentID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Agent Transactions</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
    }
    th {
      background: #f2f2f2;
    }
    h2 {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <h2>My Completed Transactions</h2>

  <?php if ($result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>Type</th>
          <th>Client</th>
          <th>Property</th>
          <th>Property Type</th>
          <th>Price</th>
          <th>Date</th>
          <th>Rental Period</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['Type'] ?></td>
            <td><?= htmlspecialchars($row['ClientName']) ?></td>
            <td><?= htmlspecialchars($row['Address']) ?></td>
            <td><?= $row['PropertyType'] ?></td>
            <td>$<?= number_format($row['FinalPrice'], 2) ?></td>
            <td><?= $row['TransactionDate'] ?></td>
            <td>
              <?php if ($row['Type'] === 'Rent'): ?>
                <?= $row['StartDate'] ?> to <?= $row['EndDate'] ?>
              <?php else: ?>
                N/A
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No transactions found for you yet.</p>
  <?php endif; ?>

  <br><a href="index.php">← Back to Home</a>
</body>
</html>
