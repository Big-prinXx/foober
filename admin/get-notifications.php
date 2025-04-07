<?php
require_once "../backend/config.php";

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch notifications for the user's orders
$sql = "SELECT notification FROM orders WHERE user_id = ? AND notification IS NOT NULL ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($notification);
$stmt->fetch();
$stmt->close();

if ($notification) {
    echo json_encode(["status" => "success", "notification" => $notification]);
} else {
    echo json_encode(["status" => "no_notification"]);
}

$conn->close();
?>