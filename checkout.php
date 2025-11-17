<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];
$customer_name = $_SESSION['customer_name'];
$customer_email = $_SESSION['customer_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get cart JSON from hidden input
    $cart = json_decode($_POST['cart_json'], true);

    if (!$cart || count($cart) === 0) {
        die("Cart is empty.");
    }

    $total_amount = 0;

    foreach ($cart as $item) {
        $product_id = intval($item['id']);
        $quantity = intval($item['qty']);
        $price = floatval($item['price']);
        $total_amount += $price * $quantity;

        // Insert purchase record
        $stmt = $conn->prepare("INSERT INTO purchases (product_id, cost_price, selling_price, purchase_date, quantity) VALUES (?, ?, ?, NOW(), ?)");
        $stmt->bind_param("iddi", $product_id, $price, $price, $quantity);
        $stmt->execute();
        $stmt->close();
    }

    // Clear cart in localStorage via JS
    echo "<script>
        localStorage.removeItem('cart');
        alert('Purchase successful! Total amount: NPR $total_amount');
        window.location.href='invoice.php?total=$total_amount';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout - ToyShop</title>
<style>
body { font-family:sans-serif; padding:20px; background:#f5f8fa; }
h1 { color:#2ecc71; text-align:center; }
.checkout-container { max-width:700px; margin:auto; background:#fff; padding:20px; border-radius:10px; box-shadow:0 5px 20px rgba(0,0,0,0.1);}
label { display:block; margin:10px 0 5px; }
input[type=text], input[type=number] { width:100%; padding:10px; margin-bottom:10px; border:1px solid #ccc; border-radius:5px; }
button { background:#2ecc71; color:#fff; border:none; padding:12px 20px; border-radius:5px; cursor:pointer; font-size:16px; }
button:hover { background:#27ae60; }
.cart-summary { margin-bottom:20px; }
.cart-summary ul { list-style:none; padding:0; }
.cart-summary li { padding:5px 0; }
.total { font-weight:600; margin-top:10px; text-align:right; }
</style>
</head>
<body>
<h1>Checkout</h1>
<div class="checkout-container">
    <h2>Confirm Your Order</h2>
    <div class="cart-summary">
        <ul id="cart-items"></ul>
        <div class="total">Total: NPR <span id="total-amount">0</span></div>
    </div>

    <h2>Payment Details</h2>
    <form method="POST" onsubmit="prepareCart()">
        <label>Card Number</label>
        <input type="text" name="card_number" placeholder="XXXX-XXXX-XXXX-XXXX" required>
        <label>Name on Card</label>
        <input type="text" name="card_name" placeholder="John Doe" required>
        <label>Expiry</label>
        <input type="text" name="card_expiry" placeholder="MM/YY" required>
        <label>CVV</label>
        <input type="number" name="card_cvv" placeholder="123" required>

        <input type="hidden" name="cart_json" id="cart_json">
        <button type="submit">Pay & Confirm</button>
    </form>
</div>

<script>
// Load cart from localStorage
let cart = JSON.parse(localStorage.getItem('cart')) || [];
const cartItems = document.getElementById('cart-items');
const totalAmountEl = document.getElementById('total-amount');
let total = 0;

cart.forEach(p => {
    let li = document.createElement('li');
    li.textContent = `${p.name} x${p.qty || 1} = NPR ${p.price * (p.qty || 1)}`;
    cartItems.appendChild(li);
    total += p.price * (p.qty || 1);
});
totalAmountEl.textContent = total;

// Set hidden input before submit
function prepareCart() {
    document.getElementById('cart_json').value = JSON.stringify(cart);
}
</script>
</body>
</html>
