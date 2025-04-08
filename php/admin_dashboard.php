<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'header.php';
include 'db.php';
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">👋 Welcome, Admin!</h2>
    <p class="text-center">You are logged in as: <strong><?php echo $_SESSION['username']; ?></strong></p>

    <div class="d-flex justify-content-center mb-4">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- Agents -->
    <h4 class="mt-5">🏢 Registered Agents</h4>
    <?php $result = $conn->query("SELECT * FROM agent"); ?>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>AgentID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Contact Info</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?= $row['AgentID'] ?></td>
                <td><?= $row['Name'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['ContactInfo'] ?></td>
                <td>
                    <a href="delete_agent.php?id=<?= $row['AgentID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this agent?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Clients -->
    <h4 class="mt-5">🧍️ Registered Clients</h4>
    <?php $result = $conn->query("SELECT * FROM client"); ?>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ClientID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Contact Info</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?= $row['ClientID'] ?></td>
                <td><?= $row['Name'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['ContactInfo'] ?></td>
                <td><?= $row['ClientType'] ?></td>
                <td>
                    <a href="delete_client.php?id=<?= $row['ClientID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this client?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Owners -->
    <h4 class="mt-5">👨‍🏠 Registered Property Owners</h4>
    <?php $result = $conn->query("SELECT * FROM owner"); ?>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>OwnerID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Contact Info</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?= $row['OwnerID'] ?></td>
                <td><?= $row['Name'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['ContactInfo'] ?></td>
                <td>
                    <a href="delete_owner.php?id=<?= $row['OwnerID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this owner?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Properties -->
    <h4 class="mt-5">🏠 Properties</h4>
    <?php $result = $conn->query("SELECT * FROM property"); ?>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>PropertyID</th>
                <th>Address</th>
                <th>Type</th>
                <th>Size (m²)</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?= $row['PropertyID'] ?></td>
                <td><?= $row['Address'] ?></td>
                <td><?= $row['Type'] ?></td>
                <td><?= $row['Size'] ?></td>
                <td><?= $row['Price'] ?></td>
                <td><?= $row['Status'] ?></td>
                <td>
                    <a href="delete_property_admin.php?id=<?= $row['PropertyID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this property?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Transactions -->
    <h4 class="mt-5">💼 Transactions</h4>
    <?php $result = $conn->query("SELECT * FROM transaction"); ?>
    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>TransactionID</th>
                    <th>ClientID</th>
                    <th>PropertyID</th>
                    <th>TransactionDate</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['TransactionID'] ?></td>
                    <td><?= $row['ClientID'] ?></td>
                    <td><?= $row['PropertyID'] ?></td>
                    <td><?= $row['TransactionDate'] ?></td>
                    <td><?= $row['Amount'] ?></td>
                    <td>
                        <a href="delete_transaction.php?id=<?= $row['TransactionID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this transaction?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No transactions found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>