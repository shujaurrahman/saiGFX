<?php



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

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Log request details
error_log('Request Method: ' . $_SERVER['REQUEST_METHOD']);
error_log('Request URI: ' . $_SERVER['REQUEST_URI']);
error_log('Raw input: ' . file_get_contents('php://input'));

require_once('logics.class.php');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode([
        'status' => 0,
        'message' => 'Please login first'
    ]);
    exit;
}

// Get POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Log the received data for debugging
error_log('Received data: ' . print_r($data, true));
error_log('Session data: ' . print_r($_SESSION, true));

if (!isset($data['product_id'])) {
    echo json_encode([
        'status' => 0,
        'message' => 'Product ID is required'
    ]);
    exit;
}

try {
    $Obj = new logics();
    $result = $Obj->addToCart($_SESSION['id'], $data['product_id'], 1);
    
    // Log the result for debugging
    error_log('Add to cart result: ' . print_r($result, true));
    
    if ($result['status'] === 1) {
        echo json_encode([
            'status' => 1,
            'message' => 'Product added to cart successfully'
        ]);
    } else if ($result['status'] === 2) {
        // Quantity updated
        echo json_encode([
            'status' => 2,
            'message' => 'Product already in cart, quantity increased'
        ]);
    } else {
        echo json_encode([
            'status' => 0,
            'message' => $result['error'] ?? 'Failed to add product to cart'
        ]);
    }
} catch (Exception $e) {
    error_log('Add to cart error: ' . $e->getMessage());
    error_log('Stack trace: ' . $e->getTraceAsString());
    echo json_encode([
        'status' => 0,
        'message' => 'An error occurred while adding to cart: ' . $e->getMessage()
    ]);
}