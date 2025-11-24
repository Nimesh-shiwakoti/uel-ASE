<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// The user is logged in, you can now show the dashboard content
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Star Robotics and Toy Shop</title>
    <style>
        body {
            background-color: #009d6c; /* Parrot Green */
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
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9); /* Slightly white background for contrast */
            border-radius: 10px;
        }
        .buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
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
            flex: 1 1 calc(50% - 20px);
            box-sizing: border-box;
            transition: background 0.3s ease;
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
            transition: background 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #ff3333;
        }
        @media (max-width: 600px) {
            .button {
                flex: 1 1 100%;
            }
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
        <a href="manage_order.php" class="button">Manage Orders</a> <!-- New Button -->
    </div>

    <!-- Logout Button -->
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>
