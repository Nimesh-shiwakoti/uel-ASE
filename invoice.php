<?php
session_start();
require_once 'db_connect.php';

if (!isset($_GET['invoice'])) {
    die("Invoice number not provided.");
}

$invoice_number = $_GET['invoice'];

// Fetch order details
$stmt = $conn->prepare("SELECT o.*, c.name as customer_name, c.email as customer_email 
                        FROM orders o
                        JOIN customers c ON o.customer_id = c.customer_id
                        WHERE o.invoice_number = ?");
$stmt->bind_param("s", $invoice_number);
$stmt->execute();
$order_result = $stmt->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    die("Order not found.");
}

// Fetch order items
$stmt_items = $conn->prepare("SELECT oi.*, p.product_name, p.image 
                               FROM order_items oi
                               JOIN products p ON oi.product_id = p.product_id
                               WHERE oi.order_id = ?");
$stmt_items->bind_param("i", $order['order_id']);
$stmt_items->execute();
$items_result = $stmt_items->get_result();
$order_items = [];
while ($row = $items_result->fetch_assoc()) {
    $order_items[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - <?php echo htmlspecialchars($invoice_number); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f8fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .invoice-container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #2ecc71;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #2ecc71;
            margin: 0;
        }
        .header .invoice-info {
            text-align: right;
        }
        .invoice-info p {
            margin: 2px 0;
        }
        .customer-details, .address-details {
            margin-bottom: 20px;
        }
        h2 {
            color: #2ecc71;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background: #2ecc71;
            color: #fff;
        }
        table td img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
        .total {
            text-align: right;
            font-size: 1.2rem;
            font-weight: 600;
            margin-top: 20px;
        }
        .btn-back {
            display: inline-block;
            background: #2ecc71;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
        }
        .btn-back:hover {
            background: #27ae60;
        }
    </style>
</head>
<body>
<div class="invoice-container">
    <div class="header">
        <h1>ToysZone.com</h1>
        <div class="invoice-info">
            <p><strong>Invoice:</strong> <?php echo htmlspecialchars($order['invoice_number']); ?></p>
            <p><strong>Date:</strong> <?php echo date('d M Y', strtotime($order['order_date'])); ?></p>
        </div>
    </div>

    <div class="customer-details">
        <h2>Customer Details</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['customer_email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone_number']); ?></p>
    </div>

    <div class="address-details">
        <h2>Delivery Address</h2>
        <p><?php echo htmlspecialchars($order['street_address']); ?>, <?php echo htmlspecialchars($order['city']); ?>, <?php echo htmlspecialchars($order['postal_code']); ?></p>
    </div>

    <h2>Order Items</h2>
    <table>
        <tr>
            <th>Image</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price (NPR)</th>
            <th>Total (NPR)</th>
        </tr>
        <?php foreach($order_items as $item): ?>
        <tr>
            <td>
                <?php 
                $img_path = (!empty($item['image']) && file_exists($_SERVER['DOCUMENT_ROOT'].'/toys/'.$item['image'])) ? $item['image'] : 'uploads/placeholder.png'; 
                ?>
                <img src="<?php echo $img_path; ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
            </td>
            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
            <td><?php echo intval($item['quantity']); ?></td>
            <td><?php echo number_format($item['price'], 2); ?></td>
            <td><?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="total">
        Total Amount: NPR <?php echo number_format($order['total_amount'], 2); ?>
    </div>

    <div style="text-align:center; margin-top:30px;">
        <a href="client_dashboard.php" class="btn-back">Continue Shopping</a>
    </div>
</div>
</body>
</html>
