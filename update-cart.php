<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 0, 'message' => 'Please login to continue']);
    exit;
}

// Get JSON data from request
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate input
if (!isset($data['cart_id']) || !isset($data['quantity'])) {
    echo json_encode(['status' => 0, 'message' => 'Invalid input']);
    exit;
}

$cart_id = intval($data['cart_id']);
$quantity = intval($data['quantity']);
$user_id = $_SESSION['id'];

// Validate quantity
if ($quantity < 1 || $quantity > 99) {
    echo json_encode(['status' => 0, 'message' => 'Invalid quantity']);
    exit;
}

require_once('logics.class.php');
$Obj = new logics();

// Update cart quantity
$result = $Obj->UpdateCartQuantity($cart_id, $quantity, $user_id);

echo json_encode($result); 