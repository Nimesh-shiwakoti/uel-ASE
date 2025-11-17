<?php
// fetch_product_details.php

header('Content-Type: application/json');
require_once 'db_connect.php';

// Check if product_id is provided
if (!isset($_GET['product_id']) || empty($_GET['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'Product ID is required.']);
    exit();
}

$product_id = intval($_GET['product_id']);

// Fetch product details
$product_query = "SELECT product_id, product_name, image FROM products WHERE product_id = ?";
$stmt = $conn->prepare($product_query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Product not found.']);
    exit();
}

$product = $result->fetch_assoc();

// Calculate current stock
$purchase_query = "SELECT SUM(quantity) as total_purchased, SUM(quantity) as total_sold 
                  FROM (
                      SELECT quantity FROM purchases WHERE product_id = ?
                      UNION ALL
                      SELECT quantity FROM sales WHERE product_id = ?
                  ) as combined";
$stmt_stock = $conn->prepare("
    SELECT 
        IFNULL((SELECT SUM(quantity) FROM purchases WHERE product_id = ?) , 0) 
        - IFNULL((SELECT SUM(quantity) FROM sales WHERE product_id = ?), 0) AS current_stock
");
$stmt_stock->bind_param("ii", $product_id, $product_id);
$stmt_stock->execute();
$result_stock = $stmt_stock->get_result();
$stock_data = $result_stock->fetch_assoc();
$current_stock = $stock_data['current_stock'];

// Fetch latest selling price from purchases
$price_query = "SELECT selling_price FROM purchases WHERE product_id = ? ORDER BY purchase_date DESC LIMIT 1";
$stmt_price = $conn->prepare($price_query);
$stmt_price->bind_param("i", $product_id);
$stmt_price->execute();
$result_price = $stmt_price->get_result();
if ($result_price->num_rows > 0) {
    $price_data = $result_price->fetch_assoc();
    $latest_selling_price = $price_data['selling_price'];
} else {
    $latest_selling_price = 0.00; // Default if no selling price found
}

// Prepare the response
$response = [
    'success' => true,
    'product_id' => $product['product_id'],
    'product_name' => $product['product_name'],
    'image' => $product['image'] ? $product['image'] : 'no_image.png',
    'current_stock' => $current_stock,
    'latest_selling_price' => $latest_selling_price
];

echo json_encode($response);
?>
