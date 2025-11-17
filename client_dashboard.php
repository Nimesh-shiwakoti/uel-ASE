<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

// Pagination settings
$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Total products count
$count_result = $conn->query("SELECT COUNT(*) as total FROM products");
$total_products = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_products / $limit);

// Fetch products, best-selling first
$query = "SELECT p.product_id, p.product_name, p.description, p.image,
                 IFNULL(SUM(s.quantity),0) as sold_quantity
          FROM products p
          LEFT JOIN sales s ON p.product_id = s.product_id
          GROUP BY p.product_id
          ORDER BY sold_quantity DESC
          LIMIT $start, $limit";

$result = $conn->query($query);

// Latest selling price for each product
$price_query = "SELECT product_id, selling_price FROM purchases GROUP BY product_id";
$price_result = $conn->query($price_query);
$prices = [];
while($row = $price_result->fetch_assoc()){
    $prices[$row['product_id']] = $row['selling_price'];
}

// Fetch customer profile image
$customer_id = $_SESSION['customer_id'];
$profile_image = 'uploads/placeholder.png'; // default
$stmt = $conn->prepare("SELECT profile_image FROM customers WHERE customer_id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$stmt->bind_result($db_profile_image);
$stmt->fetch();
$stmt->close();
if(!empty($db_profile_image)){
    $profile_image = $db_profile_image;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ToysZone.com Dashboard</title>
    <link rel="stylesheet" href="client_dashboard.css">
    <script src="client_dashboard.js" defer></script>
</head>
<body>
<header>
    <div class="header-left">
        <img src="<?php echo $profile_image; ?>" alt="Profile Picture" class="profile-pic">
    <span class="customer-name"><?php echo htmlspecialchars($_SESSION['customer_name']); ?></span>
    
    <H2>ToysZone.com</H2>
</div>
    <div class="header-right">

   
        <div class="cart-summary">
            Cart: <span id="cart-count">0</span> items
            <a href="cart.php" class="view-cart-btn">View Cart</a>
        </div>
        <a href="logout1.php" class="logout-btn">Logout</a>
    </div>
</header>
<!--
<main>
    <section class="filters">
        <label>Filter by Price: NPR <span id="price-value">0</span></label>
        <input type="range" id="price-filter" min="10" max="2500" value="300">
    </section>
-->
<br><br><br><br>
    <section class="product-grid">
        <?php while($product = $result->fetch_assoc()): ?>
            <?php
            $image_url =  $product['image'];
            if(!file_exists($image_url) || empty($product['image'])){
                $image_url = 'uploads/placeholder.png';
            }
            $price = isset($prices[$product['product_id']]) ? $prices[$product['product_id']] : 0;
            ?>
            <div class="product-card" data-price="<?php echo $price; ?>">
                <img src="<?php echo $image_url; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p>Price: NPR <?php echo $price; ?></p>
                <button class="add-to-cart"
                        data-id="<?php echo $product['product_id']; ?>"
                        data-name="<?php echo htmlspecialchars($product['product_name']); ?>"
                        data-price="<?php echo $price; ?>"
                        data-image="<?php echo $image_url; ?>">
                    Add to Cart
                </button>
            </div>
        <?php endwhile; ?>
    </section>

    <div class="pagination">
        <?php if($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>" class="prev-btn">Previous</a>
        <?php endif; ?>
        <?php if($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>" class="next-btn">Next</a>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
