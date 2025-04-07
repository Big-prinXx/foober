<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="admin-header">
        <h2>Admin Dashboard</h2>
        <a href="logout.php" class="logout-btn">Logout</a>
    </header>

    <div class="admin-container">
        <div class="admin-sidebar">
            <h3>Admin Menu</h3>
            <ul>
                <li><a href="manage-orders.php">Manage Orders</a></li>
                <li><a href="confirm-payments.php">Confirm Payments</a></li>
                <li><a href="send-notification.php">Send Notifications</a></li>
                <li><a href="assign-order-id.php">Assign Order ID</a></li>
            </ul>
        </div>

        <div class="admin-content">
            <h3>Welcome, Admin!</h3>
            <p>Use the menu to manage the system.</p>
        </div>
    </div>
</body>
</html>