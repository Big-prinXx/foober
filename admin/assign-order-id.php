<?php
require_once "../backend/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $custom_order_id = $_POST['custom_order_id'];

    if (!empty($custom_order_id)) {
        $sql = "UPDATE orders SET order_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $custom_order_id, $order_id);

        if ($stmt->execute()) {
            echo "<script>alert('Order ID Assigned Successfully!'); window.location.href='manage-orders.php';</script>";
        } else {
            echo "<script>alert('Error assigning Order ID!'); window.location.href='manage-orders.php';</script>";
        }

        $stmt->close();
    }
}
$conn->close();
?>