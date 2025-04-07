<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost"; // Change if your DB server is different
$username = "root"; // Your DB username
$password = ""; // Your DB password
$dbname = "food_ordering"; // Change this

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
} else {
    echo "Database connected successfully!";
}
?>