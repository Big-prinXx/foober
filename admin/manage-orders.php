<?php
session_start();
require_once "../backend/config.php";  // Database connection

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.html");
    exit();
}

// Fetch all orders
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="admin-header">
        <h2>Manage Orders</h2>
        <a href="admin-dashboard.php" class="back-btn">Back to Dashboard</a>
    </header>

    <div class="admin-container">
        <table>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Order ID</th>
                <th>Notification</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['items']; ?></td>
                    <td>$<?php echo number_format($row['total_price'], 2); ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['order_id'] ? $row['order_id'] : "Not Assigned"; ?></td>
                    <td><?php echo $row['notification'] ? $row['notification'] : "No Notification"; ?></td>
                    <td>
                        <form action="update-order.php" method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                            <select name="status">
                                <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Accepted" <?php if ($row['status'] == 'Accepted') echo 'selected'; ?>>Accepted</option>
                                <option value="Rejected" <?php if ($row['status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                            </select>
                            <button type="submit">Update Status</button>
                        </form>

                        <form action="assign-order-id.php" method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                            <input type="text" name="custom_order_id" placeholder="Assign Order ID">
                            <button type="submit">Assign ID</button>
                        </form>

                        <form action="send-notification.php" method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                            <textarea name="notification" placeholder="Enter Notification Message"></textarea>
                            <button type="submit">Send Notification</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>