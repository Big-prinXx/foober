<?php
require_once "../backend/config.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
        echo "<script>alert('Order status updated successfully!'); window.location.href='manage-orders.php';</script>";
    } else {
        echo "<script>alert('Error updating order!'); window.location.href='manage-orders.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>