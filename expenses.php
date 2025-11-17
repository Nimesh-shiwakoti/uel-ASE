<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize message variable
$message = "";
$totalExpenses = 0;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $user_id = $_SESSION['user_id'];
    $expense_date = date('Y-m-d'); // Current date

    // Insert the expense into the database
    $sql = "INSERT INTO expenses (description, amount, expense_date, user) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsi", $description, $amount, $expense_date, $user_id);

    if ($stmt->execute()) {
        $message = "Expense recorded successfully!";
        echo "<script>
                alert('$message');
                window.location.href = window.location.href; // Reload the page
              </script>"; // Alert for success
    } else {
        $message = "Error recording expense: " . $conn->error;
    }
    $stmt->close();
}

// Fetch total expenses
$sql = "SELECT SUM(amount) as total FROM expenses WHERE user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $totalExpenses = $row['total'] ? $row['total'] : 0;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Expenses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        h1 {
            text-align: center;
            color: #5b8c2a;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #5b8c2a;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #4a6f21;
        }
        .message {
            margin: 15px 0;
            text-align: center;
            color: #5b8c2a;
        }
        .total-expenses {
            margin-top: 20px;
            font-size: 1.2em;
            text-align: center;
            color: #d32f2f; /* Red color for total expenses */
        }
    </style>
</head>
<body>
 <button type="button" onclick="window.location.href='index.php'">Home</button>
<div class="container">
    <h1>Record Expense</h1>
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="description">Description</label>
        <input type="text" name="description" required>

        <label for="amount">Amount</label>
        <input type="number" name="amount" step="0.01" required>

        <button type="submit">Record Expense</button>
    </form>

    <div class="total-expenses">
        Total Expenses: <?php echo number_format($totalExpenses, 2); ?>
    </div>
</div>

</body>
</html>
