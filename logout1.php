<?php
session_start();
require_once 'db_connect.php';

// Fetch user info before destroying session
$customer_name = isset($_SESSION['customer_name']) ? $_SESSION['customer_name'] : '';
$customer_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : '';
$profile_image = 'uploads/placeholder.png';

if ($customer_id) {
    $stmt = $conn->prepare("SELECT profile_image FROM customers WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $stmt->bind_result($db_profile_image);
    $stmt->fetch();
    $stmt->close();

    if (!empty($db_profile_image)) {
        $profile_image = $db_profile_image;
    }
}

// Destroy session
session_unset();
session_destroy();

// Prevent browser caching to avoid showing logout page on back button
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout - ToysZone.com</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f8fa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .logout-container {
            text-align: center;
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            max-width: 400px;
        }
        .logout-container img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #2ecc71;
            margin-bottom: 20px;
        }
        h2 {
            color: #2ecc71;
            margin-bottom: 10px;
        }
        p {
            margin-bottom: 20px;
            font-size: 1rem;
        }
        .continue-btn {
            display: inline-block;
            background: #2ecc71;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
        }
        .continue-btn:hover {
            background: #27ae60;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <img src="<?php echo $profile_image; ?>" alt="Profile Picture">
        <h2>Thank you, <?php echo htmlspecialchars($customer_name); ?>!</h2>
        <p>You have successfully logged out.</p>
        <a href="index.php" class="continue-btn">Continue Shopping</a>
    </div>
</body>
</html>
