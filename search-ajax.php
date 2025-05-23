<?php

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include required files
require_once('./logics.class.php');

// Set appropriate headers for AJAX response
header('Content-Type: application/json');

try {
    $Obj = new logics();
    
    // Check if search query is provided
    if (isset($_GET['query']) && !empty($_GET['query'])) {
        $query = trim($_GET['query']);
        
        // Get search results
        $searchResults = $Obj->searchProducts($query);
        
        // Return JSON response
        echo json_encode($searchResults);
    } else {
        // Return empty result if no query provided
        echo json_encode([
            'status' => 0,
            'message' => 'No search query provided',
            'count' => 0
        ]);
    }
} catch (Exception $e) {
    // Log the error and return a user-friendly message
    error_log("Search error: " . $e->getMessage());
    echo json_encode([
        'status' => 0,
        'message' => 'An error occurred while processing your search',
        'count' => 0
    ]);
}
?>