<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Include database connection
include 'db_connect.php';

// Define the filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Base SQL query to fetch stock details
$sql = "
    SELECT 
        p.product_id,
        p.product_name,
        p.description,
        p.image,
        COALESCE(SUM(pu.quantity), 0) AS total_purchased,
        COALESCE((SELECT SUM(s.quantity) FROM sales s WHERE s.product_id = p.product_id), 0) AS total_sales,
        COALESCE(SUM(pu.cost_price * pu.quantity), 0) AS total_cost_price,
        COALESCE((SELECT SUM(s.total_price) FROM sales s WHERE s.product_id = p.product_id), 0) AS total_sales_price
    FROM 
        products p
    LEFT JOIN 
        purchases pu ON p.product_id = pu.product_id
    GROUP BY 
        p.product_id, p.product_name, p.description, p.image
";

// Modify SQL query based on filter
switch ($filter) {
    case 'out_of_stock':
        $sql .= " HAVING total_purchased - total_sales <= 0";
        break;
    case 'most_sold':
        $sql .= " ORDER BY total_sales DESC LIMIT 1";
        break;
    case 'high_profit':
        $sql .= " HAVING total_sales_price - total_cost_price > 0 ORDER BY (total_sales_price - total_cost_price) DESC LIMIT 1";
        break;
    case 'low_stock':
        $sql .= " HAVING total_purchased - total_sales <= 5"; // Set a threshold for low stock
        break;
}

// Execute the query
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Stock - Star Robotics and Toy Shop</title>
    <style>
   <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #e8f5e9;
        margin: 20px;
        color: #2e7d32;
    }

    .table-container {
        max-height: 500px; /* Set a max height for the table container */
        overflow-y: auto; /* Enable vertical scrolling */
        margin-top: 20px;
        border: 1px solid #a5d6a7;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #a5d6a7;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #c8e6c9;
        position: sticky;
        top: 0; /* Stick the header to the top */
        z-index: 1; /* Ensure the header stays above other table content */
    }

    img {
        width: 50px;
    }

    .filter-container {
        margin-bottom: 20px;
    }

    .filter-container select {
        padding: 5px;
        font-size: 16px;
    }
</style>


</head>
<body>
<button type="button" onclick="window.location.href='index.php'">Home</button>

<h1>View Stock</h1>

<div class="filter-container">
    <form method="GET" action="">
        <label for="filter">Filter by:</label>
        <select name="filter" id="filter" onchange="this.form.submit()">
            <option value="">Select Filter</option>
            <option value="out_of_stock" <?php if ($filter == 'out_of_stock') echo 'selected'; ?>>Out of Stock</option>
            <option value="most_sold" <?php if ($filter == 'most_sold') echo 'selected'; ?>>Most Sold Product</option>
            <option value="high_profit" <?php if ($filter == 'high_profit') echo 'selected'; ?>>High Profit Product</option>
            <option value="low_stock" <?php if ($filter == 'low_stock') echo 'selected'; ?>>Low Stock</option>
        </select>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Image</th>
            <th>Total Purchased</th>
            <th>Total Sales</th>
            <th>Total Cost Price</th>
            <th>Total Sales Price</th>
            <th>Remaining Stock</th>
            <th>Profit Amount</th>
            <th>Profit Percentage</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): 
            $remaining_stock = $row['total_purchased'] - $row['total_sales'];
            $profit_amount = $row['total_sales_price'] - $row['total_cost_price'];
            $profit_percentage = ($row['total_cost_price'] > 0) ? ($profit_amount / $row['total_cost_price']) * 100 : 0;
        ?>
            <tr>
                <td><?php echo $row['product_id']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><img src="<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>"></td>
                <td><?php echo $row['total_purchased']; ?></td>
                <td><?php echo $row['total_sales']; ?></td>
                <td><?php echo number_format($row['total_cost_price'], 2); ?></td>
                <td><?php echo number_format($row['total_sales_price'], 2); ?></td>
                <td><?php echo max($remaining_stock, 0); ?></td> <!-- Ensure remaining stock is not negative -->
                <td><?php echo number_format($profit_amount, 2); ?></td>
                <td><?php echo number_format($profit_percentage, 2) . '%'; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
