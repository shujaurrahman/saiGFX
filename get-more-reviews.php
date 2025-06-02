<?php
require_once('./logics.class.php');

// Set content type to JSON
header('Content-Type: application/json');

// Get parameters
$productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if (!$productId) {
    echo json_encode(['status' => 0, 'message' => 'Invalid product ID']);
    exit();
}

// Calculate offset based on page (10 reviews per page)
$offset = ($page - 1) * 10;

// Get more reviews
$Obj = new logics();
$reviews = $Obj->getMoreReviews($productId, $offset);

// Return the reviews
echo json_encode($reviews);
exit();