<?php
session_start(); // Start the session at the very top

// Ensure session cart exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Include database connection if needed
include '../backend/config.php';

// Handle adding items to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];

    // Add item to cart session
    $_SESSION['cart'][] = [
        'id' => $item_id,
        'name' => $item_name,
        'price' => $item_price
    ];
}

// Handle removing items from cart
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $removeIndex = $_GET['remove'];
    unset($_SESSION['cart'][$removeIndex]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the array
}

// Calculate total price
$total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Your Cart</h2>
    <?php if (!empty($_SESSION['cart'])): ?>
        <ul>
            <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                <li><?php echo $item['name']; ?> - $<?php echo number_format($item['price'], 2); ?> 
                    <a href="cart.php?remove=<?php echo $index; ?>">Remove</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Total:</strong> $<?php echo number_format($total_price, 2); ?></p>
        <a href="checkout.php">Proceed to Checkout</a>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</body>
</html>