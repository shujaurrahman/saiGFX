<?php
session_start();
require_once('./logics.class.php');

// Set content type to JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 0, 'message' => 'You must be logged in to post a review']);
    exit();
}

// Get JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (empty($data['product_id']) || 
    empty($data['rating']) || 
    empty($data['review_title']) || 
    empty($data['review_content'])) {
    echo json_encode(['status' => 0, 'message' => 'All fields are required']);
    exit();
}

// Sanitize and prepare data
$productId = (int)$data['product_id'];
$userId = (int)$_SESSION['id'];
$rating = (float)$data['rating'];
$reviewTitle = trim($data['review_title']);
$reviewContent = trim($data['review_content']);

// Validate rating (between 1 and 5)
if ($rating < 1 || $rating > 5) {
    echo json_encode(['status' => 0, 'message' => 'Rating must be between 1 and 5']);
    exit();
}

// Process review submission
$Obj = new logics();
$reviewData = [
    'product_id' => $productId,
    'user_id' => $userId,
    'rating' => $rating,
    'review_title' => $reviewTitle,
    'review_content' => $reviewContent
];

$result = $Obj->addReview($reviewData);

// Return response
echo json_encode($result);
exit();