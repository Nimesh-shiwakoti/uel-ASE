<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Get product details from query parameters
$product_name = htmlspecialchars($_GET['name']);
$description = htmlspecialchars($_GET['description']);
$image = htmlspecialchars($_GET['image']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Added - Star Robotics and Toy Shop</title>
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
        .product-details {
            text-align: center;
        }
        .product-details img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }
        .product-details p {
            font-size: 18px;
            margin: 10px 0;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .button-container a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #2e8b57;
            text-decoration: none;
            border-radius: 5px;
        }
        .button-container a:hover {
            background-color: #228b22;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Product Added Successfully</h1>
    <div class="product-details">
        <img src="<?php echo $image; ?>" alt="Product Image">
        <p><strong>Product Name:</strong> <?php echo $product_name; ?></p>
        <p><strong>Description:</strong> <?php echo $description; ?></p>
    </div>
    <div class="button-container">
        <a href="index.php">Go to Home</a>
    </div>
</div>

</body>
</html>
