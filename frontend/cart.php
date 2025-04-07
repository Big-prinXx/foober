
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cart_order.css">
    <link rel="stylesheet" href="menuStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="icons"><i class="fas fa-shopping-cart"></i></div>
        <h1>Your cart</h1>
    </header>

    <section class="categories">
        <div class="category">
            <li>
                <ul><a href="menu.html">Menu</a></ul>
                <ul><a href="fast_food.html">Fast Food</a></ul>
                <ul><a href="dessert.html">Dessert</a></ul>
                <ul><a href="africanfood.html">africanfood</a></ul>
            </li>
        </div>
    </section>

    <main>
        <ul id="cart-items"></ul>
        <p>Total: $ <span id="cart-total">0.00</span></p>
        <button onclick="clearCart()">Clear Cart</button>
        <button onclick="proceedToCheckout()">Proceed to Checkout</button>
    </main>

    <script src="order.js"></script>

    <script>
     function proceedToCheckout() {
    const cartData = localStorage.getItem('cart');
    if (cartData) {
        window.location.href = 'checkout.html';
    } else {
        alert('Your cart is empty!');
    }
}
</script>
</body>
</html>
