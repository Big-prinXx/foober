<?php
session_start();
$_SESSION['user_id'] = $user['id'];  // Ensure user ID is stored

// Hardcoded Admin Credentials
$admin_username = "admin";
$admin_password = "admin123"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin-dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid admin credentials!'); window.location.href='../html/admin-login.html';</script>";
    }
}
?>