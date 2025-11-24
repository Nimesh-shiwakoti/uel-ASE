<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db_connect.php';

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];
$customer_name = $_SESSION['customer_name'];
$customer_email = $_SESSION['customer_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart = json_decode($_POST['cart_json'], true);
    $street_address = $_POST['street_address'] ?? '';
    $city = $_POST['city'] ?? '';
    $postal_code = $_POST['postal_code'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';

    if (!$cart || count($cart) === 0) {
        die("Cart is empty.");
    }

    // Calculate total
    $total_amount = 0;
    foreach ($cart as $item) {
        $total_amount += $item['price'] * ($item['qty'] ?? 1);
    }

    // Generate invoice number
    $invoice_number = 'INV-' . strtoupper(substr(md5(uniqid(rand(), true)),0,12));

    // Insert order
    $stmt_order = $conn->prepare("INSERT INTO orders 
        (customer_id, street_address, city, postal_code, phone_number, order_date, total_amount, payment_status, payment_method, invoice_number)
        VALUES (?, ?, ?, ?, ?, NOW(), ?, 'Paid', 'Card', ?)");
    $stmt_order->bind_param("isssdss", $customer_id, $street_address, $city, $postal_code, $phone_number, $total_amount, $invoice_number);
    $stmt_order->execute();
    $order_id = $stmt_order->insert_id;
    $stmt_order->close();

    // Insert order items
    foreach ($cart as $item) {
        $product_id = intval($item['id']);
        $quantity = intval($item['qty'] ?? 1);
        $price = floatval($item['price']);
        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt_item->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        $stmt_item->execute();
        $stmt_item->close();
    }

    // Generate HTML invoice for email
    ob_start();
    include 'invoice_email_template.php'; // Make sure this file exists and outputs invoice HTML
    $invoice_html = ob_get_clean();

    // Send email
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'toys.bamshawali.com'; // your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@toys.bamshawali.com'; // your SMTP email
        $mail->Password   = 'Nimesh@123';      // your email password
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom('info@toys.bamshawali.com', 'ToysZone.com');
        $mail->addAddress($customer_email, $customer_name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your ToysZone.com Invoice ' . $invoice_number;
        $mail->Body    = $invoice_html;

        $mail->send();

        echo "<script>
        localStorage.removeItem('cart');
        alert('Purchase successful! Invoice sent to your email.');
        window.location.href='invoice.php?invoice=$invoice_number';
      </script>";
        exit;


    } catch (Exception $e) {
        echo "Invoice could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout - ToysZone.com</title>
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

    <h2>Delivery Details</h2>
    <form method="POST" onsubmit="prepareCart()">
        <label>Street Address</label>
        <input type="text" name="street_address" placeholder="Street address" required>
        <label>City</label>
        <input type="text" name="city" placeholder="City" required>
        <label>Postal Code</label>
        <input type="text" name="postal_code" placeholder="Postal code" required>
        <label>Phone Number</label>
        <input type="text" name="phone_number" placeholder="Contact number" required>

        <h2>Payment Details</h2>
        <label>Card Number</label>
        <input type="text" name="card_number" placeholder="XXXX-XXXX-XXXX-XXXX" required>
        <label>Name on Card</label>
        <input type="text" name="card_name" value="<?php echo htmlspecialchars($customer_name); ?>" required>
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
