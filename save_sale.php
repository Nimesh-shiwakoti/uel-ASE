<?php
// save_sale.php

header('Content-Type: application/json');
require_once 'db_connect.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the raw POST data
$input = file_get_contents('php://input');
$saleData = json_decode($input, true);

if (!$saleData || !is_array($saleData)) {
    echo json_encode(['success' => false, 'message' => 'Invalid sale data.']);
    exit();
}

// Begin transaction
$conn->begin_transaction();

try {
    foreach ($saleData as $item) {
        // Validate each sale item
        if (
            !isset($item['product_id'], $item['quantity'], $item['discount_amount'], $item['total_price']) ||
            !is_numeric($item['product_id']) ||
            !is_numeric($item['quantity']) ||
            !is_numeric($item['discount_amount']) ||
            !is_numeric($item['total_price'])
        ) {
            throw new Exception('Invalid data for one or more sale items.');
        }

        $product_id = intval($item['product_id']);
        $quantity = intval($item['quantity']);
        $discount_amount = floatval($item['discount_amount']);
        $total_price = floatval($item['total_price']);
        $sale_date = date('Y-m-d H:i:s');

        // Check current stock
        $stmt_stock = $conn->prepare("
            SELECT 
                IFNULL((SELECT SUM(quantity) FROM purchases WHERE product_id = ?), 0) 
                - IFNULL((SELECT SUM(quantity) FROM sales WHERE product_id = ?), 0) AS current_stock
        ");
        $stmt_stock->bind_param("ii", $product_id, $product_id);
        $stmt_stock->execute();
        $result_stock = $stmt_stock->get_result();
        $stock_data = $result_stock->fetch_assoc();
        $current_stock = $stock_data['current_stock'];

        if ($quantity > $current_stock) {
            throw new Exception("Insufficient stock for product ID: $product_id.");
        }

        // Insert into sales table
        $stmt_insert = $conn->prepare("
            INSERT INTO sales (product_id, quantity, discount, total_price, sale_date, user_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt_insert->bind_param("iidssi", $product_id, $quantity, $discount_amount, $total_price, $sale_date, $user_id);
        if (!$stmt_insert->execute()) {
            throw new Exception("Failed to insert sale for product ID: $product_id.");
        }
    }

    // Commit the transaction
    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Sale completed successfully.']);
} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
