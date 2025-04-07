<?php
session_start();
// admin/update_order_status.php
// (Authentication and database connection should be handled here)

// Database credentials
$host = "localhost";
$username = "root";
$password = "";
$database = "food_ordering";




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['order_id']) && isset($_POST['new_status'])) {
        $order_id = $_POST['order_id'];
        $new_status = $_POST['new_status'];

        $conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_status, $order_id);

        if ($stmt->execute()) {
            // Redirect back to the orders page with a success message
            $_SESSION['status_message'] = "Order status for ID " . $order_id . " updated to " . htmlspecialchars($new_status);
            $_SESSION['status_type'] = 'success';
            header("Location: orders.php");
            exit();
        } else {
            // Redirect back with an error message
            $_SESSION['status_message'] = "Error updating status for order ID " . $order_id . ": " . $stmt->error;
            $_SESSION['status_type'] = 'error';
            header("Location: orders.php");
            exit();
        }

        $stmt->close();
        $conn->close();
    } else {
        // If order_id or new_status is not set
        $_SESSION['status_message'] = "Invalid request: Missing order ID or status.";
        $_SESSION['status_type'] = 'error';
        header("Location: orders.php");
        exit();
    }
} else {
    // If someone tries to access this page directly
    header("Location: orders.php");
    exit();
}
?>