<!DOCTYPE html>
<html>
<head>
    <title>Payment Details</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <h1>Payment Details</h1>
    <?php
        if (isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];
            echo "<p>Your Order ID: <strong>" . htmlspecialchars($order_id) . "</strong></p>";
        }
    ?>
    <p>Please make a payment to the following account:</p>
    <ul>
        <li>Bank Name: Your Bank</li>
        <li>Account Name: Your Business Name</li>
        <li>Account Number: 1234567890</li>
    </ul>
    <p>Once you have made the payment, the admin will verify and process your order.</p>
    <p><a href="menu.php">Back to Menu</a></p>
</body>
</html>