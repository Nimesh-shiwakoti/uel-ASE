<?php
session_start();
require_once 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle date filter
$selected_date = $_GET['date'] ?? '';
$date_condition = '';
if ($selected_date) {
    $date_condition = "WHERE DATE(o.order_date) = ?";
}

// Prepare query for orders
$sql = "
SELECT o.order_id, o.invoice_number, o.order_date, o.total_amount, o.payment_status,
       c.name AS customer_name, c.email, c.profile_image,
       ot.status AS current_status
FROM orders o
JOIN customers c ON o.customer_id = c.customer_id
LEFT JOIN order_tracking ot 
  ON ot.order_id = o.order_id
  AND ot.updated_at = (SELECT MAX(updated_at) FROM order_tracking WHERE order_id = o.order_id)
";

if ($date_condition) {
    $sql .= " WHERE DATE(o.order_date) = ?";
}

$sql .= " ORDER BY o.order_date DESC";

if ($selected_date) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selected_date);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Star Robotics and Toy Shop</title>
<style>
body {
    background-color: #009d6c;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    color: #333;
}
.navbar {
    background-color: #004d00;
    padding: 15px;
    text-align: center;
    color: white;
}
.navbar h1 {
    margin: 0;
    font-size: 24px;
}
.container {
    width: 95%;
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background: rgba(255,255,255,0.95);
    border-radius: 10px;
}
.buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
}
.button {
    padding: 15px 30px;
    background-color: #2e8b57;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    font-size: 16px;
    text-align: center;
    flex: 1 1 calc(33% - 20px);
    box-sizing: border-box;
    text-overflow: ellipsis;
}
.button:hover {
    background-color: #228b22;
}
.logout-btn {
    display: block;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #ff4c4c;
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    text-align: center;
}
.logout-btn:hover {
    background-color: #ff3333;
}
h2 {
    text-align: center;
    margin: 30px 0 10px 0;
}
.date-filter {
    margin-bottom: 20px;
    text-align: center;
}
.orders-table {
    width: 100%;
    border-collapse: collapse;
    overflow-x: auto;
}
.orders-table th, .orders-table td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
    vertical-align: middle;
}
.orders-table th {
    background-color: #27ae60;
    color: #fff;
    position: sticky;
    top: 0;
}
.orders-table img {
    border-radius: 50%;
    margin-right: 5px;
    vertical-align: middle;
}
.status-badge {
    padding: 5px 10px;
    border-radius: 5px;
    color: #fff;
    font-weight: bold;
}
.status-Pending { background-color: #e67e22; }
.status-Processing { background-color: #3498db; }
.status-Packaging { background-color: #9b59b6; }
.status-Out\ for\ Delivery { background-color: #f39c12; }
.status-Delivered { background-color: #2ecc71; }

@media (max-width: 768px) {
    .button { flex: 1 1 100%; }
    .orders-table th, .orders-table td { font-size: 14px; }
}
</style>
</head>
<body>

<div class="navbar">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
</div>

<div class="container">
    <div class="buttons">
        <a href="add_product.php" class="button">Add Product</a>
        <a href="view_stock.php" class="button">View Stock</a>
        <a href="expenses.php" class="button">Expenses</a>
        <a href="transaction_history.php" class="button">Transaction History</a>
        <a href="add_user.php" class="button">Add User</a>
        <a href="purchase_product.php" class="button">Purchase Product</a>
        <a href="sell_product.php" class="button">Sell Product</a>
    </div>
    <a href="logout.php" class="logout-btn">Logout</a>

    <h2>Recent Orders & Tracking</h2>
    <div class="date-filter">
        <form method="GET">
            <label>Select Date: </label>
            <input type="date" name="date" value="<?php echo htmlspecialchars($selected_date); ?>">
            <button type="submit">Filter</button>
        </form>
    </div>

    <div style="overflow-x:auto;">
    <table class="orders-table">
        <tr>
            <th>Invoice</th>
            <th>Customer</th>
            <th>Email</th>
            <th>Products</th>
            <th>Total</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Update Status</th>
        </tr>

        <?php while($order = $result->fetch_assoc()): ?>
            <?php
            $items_query = "SELECT oi.*, p.product_name, p.image FROM order_items oi
                            JOIN products p ON oi.product_id = p.product_id
                            WHERE oi.order_id = ".$order['order_id'];
            $items_result = $conn->query($items_query);
            ?>
        <tr>
            <td><?php echo $order['invoice_number']; ?></td>
            <td>
                <?php if($order['profile_image']): ?>
                    <img src="<?php echo $order['profile_image']; ?>" width="40" height="40">
                <?php endif; ?>
                <?php echo htmlspecialchars($order['customer_name']); ?>
            </td>
            <td><?php echo htmlspecialchars($order['email']); ?></td>
            <td>
                <?php while($item = $items_result->fetch_assoc()): ?>
                    <div>
                        <img src="<?php echo $item['image']; ?>" width="40" height="40" style="object-fit:cover;">
                        <?php echo htmlspecialchars($item['product_name'])." x".$item['quantity']; ?>
                    </div>
                <?php endwhile; ?>
            </td>
            <td><?php echo $order['total_amount']; ?></td>
            <td><?php echo $order['payment_status']; ?></td>
            <td>
                <span class="status-badge status-<?php echo str_replace(' ', '\ ', $order['current_status'] ?? 'Pending'); ?>">
                    <?php echo $order['current_status'] ?? 'Pending'; ?>
                </span>
            </td>
            <td>
                <form method="POST" action="update_order_tracking.php">
                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                    <select name="status">
                        <option <?php if(($order['current_status'] ?? '')=='Pending') echo 'selected'; ?>>Pending</option>
                        <option <?php if(($order['current_status'] ?? '')=='Processing') echo 'selected'; ?>>Processing</option>
                        <option <?php if(($order['current_status'] ?? '')=='Packaging') echo 'selected'; ?>>Packaging</option>
                        <option <?php if(($order['current_status'] ?? '')=='Out for Delivery') echo 'selected'; ?>>Out for Delivery</option>
                        <option <?php if(($order['current_status'] ?? '')=='Delivered') echo 'selected'; ?>>Delivered</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    </div>
</div>
</body>
</html>
