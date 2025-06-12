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

if (!isset($data['wishlist_id'])) {
    echo json_encode(['status' => 0, 'message' => 'Wishlist ID is required']);
    exit();
}

$logics = new logics();
$result = $logics->moveToCart($data['wishlist_id'], $_SESSION['id']);
echo json_encode($result); 