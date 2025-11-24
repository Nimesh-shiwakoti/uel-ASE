<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO order_tracking (order_id, status, updated_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $order_id, $status);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php"); // back to dashboard
    exit;
}
?>
