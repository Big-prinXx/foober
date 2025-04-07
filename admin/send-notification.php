<?php
require_once "../backend/config.php"; // Adjust path if needed
session_start();

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = trim($_POST['message']);

    if (empty($message)) {
        echo json_encode(["status" => "error", "message" => "Message cannot be empty"]);
        exit();
    }

    // Insert notification for all users
    $sql = "INSERT INTO notifications (user_id, message, is_read) SELECT id, ?, 0 FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $message);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Notification sent!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to send notification"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>