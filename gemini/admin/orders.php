<?php
// admin/orders.php
// (Authentication and database connection should be handled here)

$host = "localhost";
$username = "root";
$password = "";
$database = "food_ordering";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all orders
$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>All Orders</h2>";
    echo "<table>";
    echo "<thead><tr><th>Order ID</th><th>Customer Name</th><th>Email</th><th>Address</th><th>Order Date</th><th>Total</th><th>Status</th><th>Action</th></tr></thead>";
    echo "<tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["order_id"] . "</td>";
        echo "<td>" . htmlspecialchars($row["customer_name"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["customer_email"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["customer_address"]) . "</td>";
        echo "<td>" . $row["order_date"] . "</td>";
        echo "<td>₦" . number_format($row["total_amount"], 2) . "</td>";
        echo "<td>" . htmlspecialchars($row["order_status"]) . "</td>";
        echo "<td>";
        if ($row["order_status"] == 'Pending Payment') {
            echo "<form method='POST' action='update_order_status.php'>";
            echo "<input type='hidden' name='order_id' value='" . $row["order_id"] . "'>";
            echo "<input type='hidden' name='new_status' value='Approved'>";
            echo "<button type='submit'>Approve</button>";
            echo "</form>";
        } else {
            echo "Approved"; // Or display other status options
        }
        echo "</td>";
        echo "</tr>";

        // Fetch order items for each order (optional, but good for detailed view)
        $order_id = $row["order_id"];
        $sql_items = "SELECT oi.quantity, p.name, p.price FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?";
        $stmt_items = $conn->prepare($sql_items);
        $stmt_items->bind_param("i", $order_id);
        $stmt_items->execute();
        $result_items = $stmt_items->get_result();
        if ($result_items->num_rows > 0) {
            echo "<tr><td colspan='8'><strong>Order Items:</strong><ul>";
            while ($item_row = $result_items->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($item_row["name"]) . " x " . $item_row["quantity"] . " - ₦" . number_format($item_row["price"], 2) . "</li>";
            }
            echo "</ul></td></tr>";
        }
        $stmt_items->close();
    }
    echo "</tbody></table>";
} else {
    echo "<p>No orders found.</p>";
}

$conn->close();
?>