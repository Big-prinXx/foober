<?php
header("Content-Type: application/json");

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get data from fetch request
$data = json_decode(file_get_contents("php://input"), true);

if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["success" => false, "message" => "Error decoding JSON data."]);
    exit;
}

if (!isset($data['name']) || !isset($data['email']) || !isset($data['address']) || !isset($data['cart']) || !isset($data['total'])) {
    echo json_encode(["success" => false, "message" => "Missing required data fields."]);
    exit;
}

$name = $data['name'];
$email = $data['email'];
$address = $data['address'];
$cart = $data['cart'];
$total = $data['total'];

if (empty($name) || empty($email) || empty($address) || !is_array($cart) || empty($cart)) {
    echo json_encode(["success" => false, "message" => "Please fill all fields and ensure cart is not empty."]);
    exit;
}

$name = htmlspecialchars(trim($name));
$email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
$address = htmlspecialchars(trim($address));
$cart_json = json_encode($cart);

// Database connection
$conn = new mysqli("localhost", "root", "", "food_ordering");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Use the correct column names from your database table
$stmt = $conn->prepare("INSERT INTO orders (customer_name, custom_email, custom_address, order_items, total_price) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssd", $name, $email, $address, $cart_json, $total);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to place order: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>