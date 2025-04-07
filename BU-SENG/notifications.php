<?php
require_once "config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all notifications
$sql = "SELECT message, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($message, $created_at);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .notification-box { border: 1px solid #ddd; padding: 15px; margin: 10px 0; background: #f9f9f9; }
    </style>
</head>
<body>
    <h2>Notifications</h2>
    <?php while ($stmt->fetch()): ?>
        <div class="notification-box">
            <p><?php echo htmlspecialchars($message); ?></p>
            <small><?php echo date("F j, Y, g:i a", strtotime($created_at)); ?></small>
        </div>
    <?php endwhile; ?>
    <?php $stmt->close(); $conn->close(); ?>
</body>
</html>