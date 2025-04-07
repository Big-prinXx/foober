<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $order_data_json = $_POST['order_data'];
    $order_data = json_decode($order_data_json, true);

    // Perform validation on the received data (e.g., check for empty fields)

    // Save the order to your database
    $conn = new mysqli("your_db_host", "your_db_user", "your_db_password", "your_db_name");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 1. Insert into an 'orders' table (with customer details and order timestamp)
    $order_date = date("Y-m-d H:i:s");
    $sql_order = "INSERT INTO orders (customer_name, customer_email, customer_address, order_date, total_amount, order_status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_order = $conn->prepare($sql_order);

    // Calculate total amount
    $total_amount = 0;
    foreach ($order_data as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }
    $initial_status = 'Pending Payment'; // Set initial order status

    $stmt_order->bind_param("ssssds", $name, $email, $address, $order_date, $total_amount, $initial_status);

    if ($stmt_order->execute()) {
        $order_id = $conn->insert_id; // Get the ID of the newly inserted order

        // 2. Insert into an 'order_items' table (linking order to products and quantities)
        $sql_items = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt_items = $conn->prepare($sql_items);

        foreach ($order_data as $item) {
            $stmt_items->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
            $stmt_items->execute();
        }
        $stmt_items->close();

        // Clear the user's cart (e.g., unset the session variable)
        unset($_SESSION['cart']);

        // Redirect to the payment page
        header("Location: payment.php?order_id=" . $order_id);
        exit();
    } else {
        echo "Error saving order: " . $stmt_order->error;
    }

    $stmt_order->close();
    $conn->close();
} else {
    // If someone tries to access this page directly
    header("Location: cart.php");
    exit();
}
?>