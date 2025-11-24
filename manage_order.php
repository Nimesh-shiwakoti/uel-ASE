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

// Prepare the query
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

// Add date filter
if ($date_condition) {
    $sql .= " WHERE DATE(o.order_date) = ?";
}

$sql .= " ORDER BY o.order_date DESC";

// Prepare statement
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
<title>Dashboard - Orders</title>
<style>
/* Keep your existing dashboard CSS here */
table { width:100%; border-collapse:collapse; margin:20px 0; background:#fff; }
th, td { padding:8px; text-align:left; border-bottom:1px solid #ccc; }
th { background:#27ae60; color:#fff; }
img { border-radius:50%; }
</style>
</head>
<body>

<div class="container">
<h2>Recent Orders & Tracking</h2>

<form method="GET">
    <label>Select Date: </label>
    <input type="date" name="date" value="<?php echo htmlspecialchars($selected_date); ?>">
    <button type="submit">Filter</button>
</form>

<table>
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
            <img src="<?php echo $order['profile_image']; ?>" width="40" height="40" style="vertical-align:middle;">
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
    <td><?php echo $order['current_status'] ?? 'Pending'; ?></td>
    <td>
        <form method="POST" action="update_order_tracking.php">
            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
            <select name="status">
                <option <?php if($order['current_status']=='Pending') echo 'selected'; ?>>Pending</option>
                <option <?php if($order['current_status']=='Processing') echo 'selected'; ?>>Processing</option>
                <option <?php if($order['current_status']=='Packaging') echo 'selected'; ?>>Packaging</option>
                <option <?php if($order['current_status']=='Out for Delivery') echo 'selected'; ?>>Out for Delivery</option>
                <option <?php if($order['current_status']=='Delivered') echo 'selected'; ?>>Delivered</option>
            </select>
            <button type="submit">Update</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>
</table>
</div>
</body>
</html>
