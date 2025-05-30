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
if (!isset($data['cart_id'])) {
    echo json_encode(['status' => 0, 'message' => 'Invalid input']);
    exit;
}

$cart_id = intval($data['cart_id']);
$user_id = $_SESSION['id'];

require_once('logics.class.php');
$Obj = new logics();

// Remove cart item
$result = $Obj->DeleteCartItem($cart_id, $user_id);

echo json_encode($result); 