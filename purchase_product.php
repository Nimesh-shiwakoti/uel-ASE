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
require 'db_connect.php';

// Fetch products from the database
$sql = "SELECT product_id, product_name, description, image FROM products";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input from the form
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $cost_price = mysqli_real_escape_string($conn, $_POST['cost_price']);
    $selling_price = mysqli_real_escape_string($conn, $_POST['selling_price']);
    $purchase_date = mysqli_real_escape_string($conn, $_POST['purchase_date']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    
    // Insert purchase details into the database
    $sql = "INSERT INTO purchases (product_id, cost_price, selling_price, purchase_date, quantity) 
            VALUES ('$product_id', '$cost_price', '$selling_price', '$purchase_date', '$quantity')";
    
    if (mysqli_query($conn, $sql)) {
        // Redirect to the summary page with relevant information
        header("Location: purchase_summary.php?product_id=$product_id&quantity=$quantity&cost_price=$cost_price&selling_price=$selling_price");
        exit();
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
    
    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Product - Star Robotics and Toy Shop</title>
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
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #2e8b57;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-group button:hover {
            background-color: #228b22;
        }
        .message {
            text-align: center;
            margin: 20px 0;
            color: #d9534f;
        }
        #productImage {
            width: 120px;
            height: 120px;
            display: block;
            margin: 20px auto;
        }
        .description {
            margin-top: 15px;
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body>
    <button type="button" onclick="window.location.href='index.php'">Home</button>


<div class="container">
    <h1>Purchase Product</h1>

    <?php if (isset($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form action="purchase_product.php" method="post">
        <div class="form-group">
            <label for="product_id">Select Product:</label>
            <select id="product_id" name="product_id" onchange="updateProductDetails()">
                <option value="">Select a product</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo $product['product_id']; ?>" data-image="<?php echo $product['image']; ?>" data-description="<?php echo $product['description']; ?>">
                        <?php echo $product['product_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="product_id_display">Product ID:</label>
            <input type="text" id="product_id_display" readonly>
        </div>
        
        <div class="form-group">
            <img id="productImage" src="#" alt="Product Image" style="display:none;">
            <div class="description" id="productDescription"></div>
        </div>
        
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" step="1" min="1" required>
        </div>
        
        <div class="form-group">
            <label for="cost_price">Cost Price:</label>
            <input type="number" id="cost_price" name="cost_price" step="0.01" required>
        </div>
        
        <div class="form-group">
            <label for="selling_price">Selling Price:</label>
            <input type="number" id="selling_price" name="selling_price" step="0.01" required>
        </div>
        
        <div class="form-group">
            <label for="purchase_date">Purchase Date:</label>
            <input type="date" id="purchase_date" name="purchase_date" required>
        </div>
        
        <div class="form-group">
            <button type="submit">Purchase</button>
        </div>
    </form>
</div>

<script>
    function updateProductDetails() {
        const productSelect = document.getElementById('product_id');
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const imageUrl = selectedOption.getAttribute('data-image');
        const description = selectedOption.getAttribute('data-description');
        const imageElement = document.getElementById('productImage');
        const productIdDisplay = document.getElementById('product_id_display');
        const descriptionElement = document.getElementById('productDescription');

        if (imageUrl) {
            const fullImageUrl = imageUrl; // Use imageUrl directly if it already contains the correct path
            imageElement.src = fullImageUrl;
            imageElement.style.display = 'block';
            
            // Display the selected product ID and description
            productIdDisplay.value = productSelect.value;
            descriptionElement.textContent = description;
        } else {
            imageElement.src = '#';
            imageElement.style.display = 'none';
            productIdDisplay.value = '';
            descriptionElement.textContent = '';
        }
    }
</script>

</body>
</html>
