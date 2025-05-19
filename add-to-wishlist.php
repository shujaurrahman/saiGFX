<?php
session_start();

// Add CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 0, 'message' => 'Please login first']);
    exit();
}

require_once 'logics.class.php';

// Get the raw POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!isset($data['product_id'])) {
    echo json_encode(['status' => 0, 'message' => 'Product ID is required']);
    exit();
}

$logics = new logics();

// Check if product is already in wishlist
$wishlistItems = $logics->getWishlistByUserId($_SESSION['id']);
$alreadyInWishlist = false;

if (!empty($wishlistItems['items'])) {
    foreach ($wishlistItems['items'] as $item) {
        if ($item['product_id'] == $data['product_id']) {
            $alreadyInWishlist = true;
            break;
        }
    }
}

if ($alreadyInWishlist) {
    echo json_encode(['status' => 2, 'message' => 'Already in wishlist']);
    exit();
}

// Add to wishlist if not already present
$result = $logics->addToWishlist($_SESSION['id'], $data['product_id']);
echo json_encode($result);