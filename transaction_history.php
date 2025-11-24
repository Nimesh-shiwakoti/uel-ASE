<?php
include 'db_connect.php';

// Initialize variables for filtering
$filter_date = '';
$filter_month = '';
$filter_year = '';
$filter_username = 'all'; // Default to 'all' users

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filter_date = isset($_POST['filter_date']) ? $_POST['filter_date'] : '';
    $filter_month = isset($_POST['filter_month']) ? $_POST['filter_month'] : '';
    $filter_year = isset($_POST['filter_year']) ? $_POST['filter_year'] : '';
    $filter_username = isset($_POST['filter_username']) ? $_POST['filter_username'] : 'all';
}

// Fetch list of usernames for the dropdown
$usernames = [];
$user_query = "SELECT username FROM users ORDER BY username ASC";
$user_result = mysqli_query($conn, $user_query);

if ($user_result) {
    while ($user_row = mysqli_fetch_assoc($user_result)) {
        $usernames[] = $user_row['username'];
    }
} else {
    // Handle query error
    die("Error fetching usernames: " . mysqli_error($conn));
}

// Fetch total sales per user per day based on filters
$sql = "
    SELECT 
        u.username,
        DATE(s.sale_date) AS sale_date,
        SUM(s.total_price) AS total_sales
    FROM 
        sales s
    JOIN 
        users u ON s.user_id = u.user_id
";

$conditions = [];
if (!empty($filter_date)) {
    $conditions[] = "DATE(s.sale_date) = '" . mysqli_real_escape_string($conn, $filter_date) . "'";
}
if (!empty($filter_month)) {
    $conditions[] = "MONTH(s.sale_date) = " . (int)$filter_month;
}
if (!empty($filter_year)) {
    $conditions[] = "YEAR(s.sale_date) = " . (int)$filter_year;
}
if (!empty($filter_username) && $filter_username !== 'all') { // **Added Username Filter**
    $conditions[] = "u.username = '" . mysqli_real_escape_string($conn, $filter_username) . "'";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= "
    GROUP BY 
        u.user_id, DATE(s.sale_date)
    ORDER BY 
        sale_date DESC, u.username ASC
";

$result = mysqli_query($conn, $sql);
$sales_data = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sales_data[] = $row;
    }
} else {
    die("Error fetching sales data: " . mysqli_error($conn));
}

// Fetch total sales across all users based on filters
$total_sales_sql = "
    SELECT 
        SUM(s.total_price) AS total_sales
    FROM 
        sales s
    JOIN 
        users u ON s.user_id = u.user_id
";

if (!empty($conditions)) {
    $total_sales_sql .= " WHERE " . implode(' AND ', $conditions);
}

$total_sales_result = mysqli_query($conn, $total_sales_sql);
$total_sales_row = mysqli_fetch_assoc($total_sales_result);
$total_sales_all_users = $total_sales_row['total_sales'] ?? 0;

// **New: Fetch detailed sales based on filters**
$detailed_sales_sql = "
    SELECT 
        s.sale_id,
        p.product_id,         -- Added Product ID
        p.product_name,
        s.quantity,
        s.discount,
        s.total_price,
        DATE(s.sale_date) AS sale_date,
        u.username
    FROM 
        sales s
    JOIN 
        users u ON s.user_id = u.user_id
    JOIN 
        products p ON s.product_id = p.product_id
";

if (!empty($conditions)) {
    $detailed_sales_sql .= " WHERE " . implode(' AND ', $conditions);
}

$detailed_sales_sql .= "
    ORDER BY 
        s.sale_date DESC, u.username ASC, p.product_name ASC
";

$detailed_sales_result = mysqli_query($conn, $detailed_sales_sql);
$detailed_sales_data = [];

if ($detailed_sales_result) {
    while ($row = mysqli_fetch_assoc($detailed_sales_result)) {
        $detailed_sales_data[] = $row;
    }
} else {
    die("Error fetching detailed sales data: " . mysqli_error($conn));
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - Star Robotics and Toy Shop</title>
   <style>
    /* Reset some default styles */
    * {
        box-sizing: border-box;
    }
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        color: #333;
        margin: 0;
        padding: 20px;
    }

    .container {
        max-width: 1200px;
        margin: auto;
        background-color: #fff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1, h2 {
        color: #4CAF50; /* Green color for headings */
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        margin-bottom: 30px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        min-width: 200px;
    }

    label {
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="date"],
    input[type="number"],
    select {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        transition: border-color 0.3s;
        width: 100%;
    }

    input[type="date"]:focus,
    input[type="number"]:focus,
    select:focus {
        border-color: #4CAF50; /* Green focus border */
        outline: none;
    }

    button {
        padding: 12px 20px;
        background-color: #4CAF50; /* Green button */
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 16px;
        align-self: flex-end;
        height: 45px;
    }

    button:hover {
        background-color: #388E3C; /* Darker green on hover */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 40px;
        table-layout: fixed;
        word-wrap: break-word;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 12px;
        text-align: left;
        background-color: #fff;
        transition: background-color 0.3s;
    }

    th {
        background-color: #4CAF50; /* Green header */
        color: white;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    tr:hover {
        background-color: #f1f1f1; /* Light gray on hover */
    }

    td {
        color: #555;
    }

    .total-sales {
        font-size: 18px;
        text-align: right;
        margin-top: -20px;
        margin-bottom: 20px;
    }

    /* Responsive Design */
    @media (max-width: 1000px) {
        .form-group {
            min-width: 150px;
        }
    }

    @media (max-width: 768px) {
        form {
            flex-direction: column;
            align-items: stretch;
        }

        .form-group {
            width: 100%;
        }

        button {
            width: 100%;
            height: auto;
        }

        th, td {
            padding: 8px;
        }

        .total-sales {
            text-align: center;
        }
    }
    </style>

</head>
<body>
    <div class="container">
        <button type="button" onclick="window.location.href='index.php'" style="float: right; padding: 10px 15px; margin-bottom: 20px;">Home</button>
        
        <h1>Transaction History</h1>

        <form method="post" action="">
            <div class="form-group">
                <label for="filter_date">Filter by Date:</label>
                <input type="date" name="filter_date" id="filter_date" value="<?php echo htmlspecialchars($filter_date); ?>">
            </div>

            <div class="form-group">
                <label for="filter_month">Filter by Month:</label>
                <input type="number" name="filter_month" id="filter_month" min="1" max="12" placeholder="1-12" value="<?php echo htmlspecialchars($filter_month); ?>">
            </div>

            <div class="form-group">
                <label for="filter_year">Filter by Year:</label>
                <input type="number" name="filter_year" id="filter_year" min="2020" max="<?php echo date('Y'); ?>" placeholder="e.g. 2023" value="<?php echo htmlspecialchars($filter_year); ?>">
            </div>

            <div class="form-group">
                <label for="filter_username">Filter by User:</label>
                <select name="filter_username" id="filter_username">
                    <option value="all" <?php echo ($filter_username == 'all') ? 'selected' : ''; ?>>All Users</option>
                    <?php foreach ($usernames as $username) : ?>
                        <option value="<?php echo htmlspecialchars($username); ?>" <?php echo ($filter_username == htmlspecialchars($username)) ? 'selected' : ''; ?>><?php echo htmlspecialchars($username); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit">Filter</button>
        </form>

        <div class="total-sales">
            <strong>Total Sales (Filtered): </strong>
            <?php echo number_format($total_sales_all_users, 2); ?> NPR
        </div>

        <h2>Sales Summary</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Sale Date</th>
                    <th>Total Sales (NPR)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($sales_data) > 0): ?>
                    <?php foreach ($sales_data as $data): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($data['username']); ?></td>
                            <td><?php echo htmlspecialchars($data['sale_date']); ?></td>
                            <td><?php echo number_format($data['total_sales'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align:center;">No sales records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2>Detailed Sales</h2>
        <table>
            <thead>
                <tr>
                    <th>Sale ID</th>
                    <th>Product ID</th> <!-- New Product ID Column -->
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Discount (NPR)</th>
                    <th>Total Price (NPR)</th>
                    <th>Sale Date</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($detailed_sales_data) > 0): ?>
                    <?php foreach ($detailed_sales_data as $data): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($data['sale_id']); ?></td>
                            <td><?php echo htmlspecialchars($data['product_id']); ?></td> <!-- Display Product ID -->
                            <td><?php echo htmlspecialchars($data['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($data['quantity']); ?></td>
                            <td><?php echo number_format($data['discount'], 2); ?></td>
                            <td><?php echo number_format($data['total_price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($data['sale_date']); ?></td>
                            <td><?php echo htmlspecialchars($data['username']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">No detailed sales records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
