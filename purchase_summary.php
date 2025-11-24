<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Retrieve purchase details from URL parameters
$product_id = htmlspecialchars($_GET['product_id']);
$quantity = htmlspecialchars($_GET['quantity']);
$cost_price = htmlspecialchars($_GET['cost_price']);
$selling_price = htmlspecialchars($_GET['selling_price']);

// Include database connection
require 'db_connect.php';

// Fetch product details
$sql = "SELECT product_name FROM products WHERE product_id = '$product_id'";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Summary - Star Robotics and Toy Shop</title>
    <style>
        body {
            background-color: #e9f5e9;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #004d00;
            text-align: center;
        }
        .summary {
            margin: 20px 0;
        }
        .summary p {
            font-size: 18px;
            line-height: 1.5;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .button-container a {
            text-decoration: none;
            color: #fff;
            background-color: #2e8b57;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            display: inline-block;
        }
        .button-container a:hover {
            background-color: #228b22;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Purchase Summary</h1>

    <div class="summary">
        <?php if ($product): ?>
            <p><strong>Product Name:</strong> <?php echo htmlspecialchars($product['product_name']); ?></p>
            <p><strong>Quantity Purchased:</strong> <?php echo htmlspecialchars($quantity); ?></p>
            <p><strong>Cost Price:</strong> Rs<?php echo htmlspecialchars($cost_price); ?></p>
            <p><strong>Selling Price:</strong> Rs<?php echo htmlspecialchars($selling_price); ?></p>
        <?php else: ?>
            <p>Product details could not be retrieved.</p>
        <?php endif; ?>
    </div>

    <div class="button-container">
        <a href="purchase_product.php">Return to Purchase Page</a>
    </div>
</div>

</body>
</html>
