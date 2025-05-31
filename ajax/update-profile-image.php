<?php

ini_set('display_errors', 0); // Don't show errors in output
ini_set('log_errors', 1);     // Log them instead
error_reporting(E_ALL);    
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Not authenticated'
    ]);
    exit;
}

require_once '../class/User.php';

try {
    $user = new User();
    
    if (!isset($_FILES['profile_image'])) {
        throw new Exception('No image file received');
    }
    
    $result = $user->updateProfileImage($_FILES['profile_image']);
    echo json_encode($result);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}