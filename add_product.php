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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input from the form
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Handle file upload
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is a valid image
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check === false) {
        $message = "File is not an image.";
        $uploadOk = 0;
    }
    
    // Check file size (limit to 5MB)
    if ($_FILES['image']['size'] > 5000000) {
        $message = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $message = "Sorry, your file was not uploaded.";
    } else {
        // Try to upload file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $imagePath = $target_file;
        } else {
            $message = "Sorry, there was an error uploading your file.";
        }
    }
    
    if ($uploadOk == 1) {
        // Insert new product into the database
        $sql = "INSERT INTO products (product_name, description, image) 
                VALUES ('$product_name', '$description', '$imagePath')";
        
        if (mysqli_query($conn, $sql)) {
            // Redirect to the confirmation page with product details
            header("Location: confirmation.php?name=$product_name&description=$description&image=$imagePath");
            exit();
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
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
    <title>Add Product - Star Robotics and Toy Shop</title>
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
        .form-group textarea {
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
        #imagePreview {
            width: 100%;
            max-width: 300px;
            height: auto;
            display: block;
            margin: 20px auto;
        }
    </style>
</head>
<body>
<button type="button" onclick="window.location.href='index.php'">Home</button>

<div class="container">
    <h1>Add New Product</h1>
    <?php if (isset($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Product Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        <img id="imagePreview" src="#" alt="Image Preview" style="display:none;">
        <div class="form-group">
            <button type="submit">Add Product</button>
        </div>
    </form>
</div>

<script>
    // JavaScript to show image preview
    document.getElementById('image').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('imagePreview');
            preview.src = reader.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>

</body>
</html>
