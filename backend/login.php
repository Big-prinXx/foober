<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging: Print POST data
    print_r($_POST);

    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';

    if (empty($email) || empty($password)) {
        echo "<br>Email and password are required";
        exit();
    }

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION['user_email'] = $email;
        header("Location: ../frontend/menu.html");
        exit();
    } else {
        echo "<br>Invalid email or password.";
    }
}
?>