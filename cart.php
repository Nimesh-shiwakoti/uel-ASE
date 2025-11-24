<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Your Cart - Invoice</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding: 20px;
    background: #f5f8fa;
    color: #333;
}
h1 {
    color: #2ecc71;
    text-align: center;
}
.cart-container {
    max-width: 1000px;
    margin: 20px auto;
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}
th, td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}
th {
    background: #2ecc71;
    color: #fff;
    font-weight: 600;
}
img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
}
.quantity-input {
    width: 50px;
    text-align: center;
}
button.remove-btn {
    background: #e74c3c;
    color: #fff;
    border: none;
    padding: 6px 12px;
    border-radius: 5px;
    cursor: pointer;
}
button.remove-btn:hover { background:#c0392b; }
.checkout-btn {
    background: #2ecc71;
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    cursor: pointer;
    float: right;
    font-size: 16px;
}
.checkout-btn:hover { background:#27ae60; }
.total-section {
    text-align: right;
    font-size: 18px;
    font-weight: 600;
    margin-top: 10px;
}
@media(max-width:768px){
    img { width: 60px; height: 60px; }
    th, td { padding: 8px; font-size: 14px; }
    .checkout-btn { width: 100%; float:none; margin-top:10px; }
}
</style>
</head>
<body>
<h1>Your Cart</h1>

<div class="cart-container">
    <table id="cart-table">
        <thead>
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Unit Price (NPR)</th>
            <th>Quantity</th>
            <th>Subtotal (NPR)</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <div class="total-section">
        Total: NPR <span id="total-amount">0</span>
    </div>

    <button class="checkout-btn" onclick="checkout()">Proceed to Checkout</button>
</div>

<script>
// Load cart from localStorage
let cart = JSON.parse(localStorage.getItem('cart')) || [];
const tbody = document.querySelector('#cart-table tbody');
const totalAmountEl = document.getElementById('total-amount');

function renderCart() {
    tbody.innerHTML = '';
    let total = 0;
    cart.forEach((p, index) => {
        let subtotal = p.price * (p.qty || 1);
        total += subtotal;

        let row = document.createElement('tr');

        // Image
        let imgCell = document.createElement('td');
        let img = document.createElement('img');
        img.src = p.image;
        img.alt = p.name;
        imgCell.appendChild(img);
        row.appendChild(imgCell);

        // Name
        let nameCell = document.createElement('td');
        nameCell.textContent = p.name;
        row.appendChild(nameCell);

        // Unit Price
        let priceCell = document.createElement('td');
        priceCell.textContent = p.price;
        row.appendChild(priceCell);

        // Quantity
        let qtyCell = document.createElement('td');
        let qtyInput = document.createElement('input');
        qtyInput.type = 'number';
        qtyInput.min = 1;
        qtyInput.value = p.qty || 1;
        qtyInput.classList.add('quantity-input');
        qtyInput.onchange = () => {
            cart[index].qty = parseInt(qtyInput.value);
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        };
        qtyCell.appendChild(qtyInput);
        row.appendChild(qtyCell);

        // Subtotal
        let subtotalCell = document.createElement('td');
        subtotalCell.textContent = subtotal;
        row.appendChild(subtotalCell);

        // Remove button
        let actionCell = document.createElement('td');
        let btn = document.createElement('button');
        btn.textContent = 'Remove';
        btn.classList.add('remove-btn');
        btn.onclick = () => {
            cart.splice(index,1);
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        };
        actionCell.appendChild(btn);
        row.appendChild(actionCell);

        tbody.appendChild(row);
    });
    totalAmountEl.textContent = total;
}

// Initial render
renderCart();

function checkout() {
    if(cart.length === 0){
        alert("Your cart is empty!");
        return;
    }
    // Save cart for backend processing
    localStorage.setItem('cart', JSON.stringify(cart));
    window.location.href = 'checkout.php';
}
</script>
</body>
</html>
