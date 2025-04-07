let cart = JSON.parse(localStorage.getItem("cart")) || [];


function AddToCart(productId, name, price) {
    const existingItem = cart.find(item => item.productId === productId);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({ productId, name, price, quantity: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    updateCartTotal(); // Call updateCartTotal after adding to cart
}

function updateCartCount() {
    const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
    document.getElementById("cart-count").textContent = totalQuantity;
}

function updateCartTotal() {
    let total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    localStorage.setItem("cartTotal", total.toFixed(2)); // Store the total in localStorage
}

function loadCart() {
    let cartItems = document.getElementById("cart-items");
    let cartTotal = document.getElementById("cart-total");
    let total = 0;

    cartItems.innerHTML = "";
    cart.forEach((item, index) => {
        total += item.price * item.quantity;
        cartItems.innerHTML += <li>${item.name} x ${item.quantity} - $${(item.price * item.quantity).toFixed(2)} <button onclick="removeFromCart(${item.productId})">Remove</button></li>;
    });

    cartTotal.textContent = total.toFixed(2);
    localStorage.setItem("cartTotal", total.toFixed(2)); // Ensure total is stored on load as well
}

function removeFromCart(productId) {
    cart = cart.filter(item => item.productId !== productId);
    localStorage.setItem("cart", JSON.stringify(cart));
    loadCart();
    updateCartCount();
}

function clearCart() {
    cart = [];
    localStorage.removeItem("cart");
    localStorage.removeItem("cartTotal"); // Clear the total as well
    localCart(); // Assuming this function reloads the cart display
    updateCartCount();
}

if (document.getElementById("cart-items")) {
    loadCart();
} else {
    updateCartCount();
}

function fetchNotification() {
    fetch("get-notifications.php")
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                document.getElementById("notification-message").innerText = data.notification;
                document.getElementById("notification-popup").style.display = "block";
            }
        });
}

function closePopup() {
    document.getElementById("notification-popup").style.display = "none";
}

// Check for new notifications every 10 seconds
setInterval(fetchNotification, 10000);