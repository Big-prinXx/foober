<?php
session_start();
include '../backend/config.php'; // Ensure correct path

// Fetch cart items (Assuming items are stored in $_SESSION['cart'])
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $payment_method = $_POST['payment_method'];

    if ($name == "" || $email == "" || $address == "" || empty($cart)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        // Save order in database
        $order_query = "INSERT INTO orders (name, email, address, total_price, payment_method, status) VALUES (?, ?, ?, ?, ?, 'Pending')";
        $stmt = $conn->prepare($order_query);
        $stmt->bind_param("sssis", $name, $email, $address, $total, $payment_method);
        if ($stmt->execute()) {
            $_SESSION['cart'] = [];
            echo "<script>alert('Order placed successfully!'); window.location.href='confirmation.php';</script>";
        } else {
            echo "<script>alert('Order failed!');</script>";
        }
    }
}
?><!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .checkout-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2, h3 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
        }
        input, textarea, select {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <h2>Checkout</h2>
        <form method="POST">
            <label>Name:</label>
            <input type="text" name="name" required><label>Email:</label>
        <input type="email" name="email" required>
        
        <label>Address:</label>
        <textarea name="address" required></textarea>
        
        <h3>Order Summary</h3>
        <ul>
            <?php foreach ($cart as $item): ?>
                <li><?php echo $item['name'] . " - " . $item['quantity'] . " x $" . $item['price']; ?></li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Total: $<?php echo number_format($total, 2); ?></strong></p>
        
        <label>Payment Method:</label>
        <select name="payment_method">
            <option value="card">Credit/Debit Card</option>
            <option value="bank_transfer">Bank Transfer</option>
        </select>
        
        <button type="submit">Place Order</button>
    </form>
</div>

</body>
</html>