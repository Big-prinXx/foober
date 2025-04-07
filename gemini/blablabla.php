<?php
header("Content-Type: application/json");

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get data from fetch request
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid or missing data."]);
    exit;
}

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$address = $data['address'] ?? '';
$cart = $data['cart'] ?? [];
$total = $data['total'] ?? 0;

if (empty($name) || empty($email) || empty($address) || empty($cart)) {
    echo json_encode(["success" => false, "message" => "Please fill all fields and ensure cart is not empty."]);
    exit;
}

$cart_json = json_encode($cart);

// Database connection (change database name if needed)
$conn = new mysqli("localhost", "root", "", "food_ordering"); // Change this

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit;
}

// Insert order into database
$stmt = $conn->prepare("INSERT INTO orders (customer_name, custom_email, custom_address, order_items, total_price) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssd", $name, $email, $address, $cart_json, $total);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to place order."]);
}

$stmt->close();
$conn->close();
?>