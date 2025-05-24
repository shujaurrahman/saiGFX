<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 0, 'message' => 'User not logged in']);
    exit;
}

require_once('logics.class.php');
$Obj = new logics();

// Get cart items count
$cartItems = $Obj->getCartById($_SESSION['id']);

echo json_encode([
    'status' => 1,
    'count' => isset($cartItems['count']) ? $cartItems['count'] : 0
]);