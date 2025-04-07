<?php
session_start(); // Make sure you have session started on your cart page as well

// Replace this with your actual logic to fetch cart data
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$items_data = [];

// Assuming your cart structure is an array of product IDs with quantities
// You'll need to fetch product details (name, price) from your database
// based on these IDs.
// Example (adjust based on your database structure):
$host = "localhost";
$username = "root";
$password = "";
$database = "food_ordering";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

foreach ($cart_items as $product_id => $quantity) {
    $sql = "SELECT id, name, price FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $items_data['items'][] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'quantity' => $quantity
        ];
    }
    $stmt->close();
}
$conn->close();

header('Content-Type: application/json');
echo json_encode($items_data);
?>