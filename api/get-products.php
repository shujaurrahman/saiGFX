<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Enable error reporting but log to file
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

try {
    // Read the static JSON file
    $jsonFile = __DIR__ . '/products.json';
    
    if (!file_exists($jsonFile)) {
        throw new Exception('Products data file not found');
    }
    
    $jsonContent = file_get_contents($jsonFile);
    if ($jsonContent === false) {
        throw new Exception('Failed to read products data file');
    }
    
    $data = json_decode($jsonContent, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON data: ' . json_last_error_msg());
    }
    
    // Filter out products that are not approved
    $approvedProducts = [];
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $approvedProducts[$key] = [];
            for ($i = 0; $i < count($value); $i++) {
                if ($data['verification_status'][$i] === 'approved') {
                    $approvedProducts[$key][] = $value[$i];
                }
            }
        } else {
            $approvedProducts[$key] = $value;
        }
    }
    
    // Update the count
    $approvedProducts['count'] = count($approvedProducts['id']);
    
    // Return the filtered data
    echo json_encode($approvedProducts);
    
} catch (Exception $e) {
    error_log('Error in get-products.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 0,
        'message' => 'Error loading products: ' . $e->getMessage()
    ]);
}