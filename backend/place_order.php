<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "food_ordering"; // update if yours is different

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Get JSON input from JavaScript
$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'];
$email = $data['email'];
$address = $data['address'];
$cartItems = $data['cart'];
$total = $data['total'];

if (!empty($name) && !empty($email) && !empty($address) && !empty($cartItems)) {
    $stmt = $conn->prepare("INSERT INTO orders (name, email, address, items, total_price, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $items_json = json_encode($cartItems);
    $stmt->bind_param("ssssd", $name, $email, $address, $items_json, $total);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to save order"]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Incomplete data"]);
}

$conn->close();
?>