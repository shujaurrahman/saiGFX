<?php
session_start();
require_once('./logics.class.php');

// Send JSON header
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 0, 'message' => 'You must be logged in to follow users']);
    exit;
}

// Get user ID from either JSON input or POST data
$user_id = 0;

// Try to parse JSON input
$json_data = file_get_contents('php://input');
if (!empty($json_data)) {
    $data = json_decode($json_data, true);
    $user_id = isset($data['user_id']) ? (int)$data['user_id'] : 0;
}

// If not in JSON, check POST data
if ($user_id === 0 && isset($_POST['user_id'])) {
    $user_id = (int)$_POST['user_id'];
}

// Validate user ID
if (!$user_id) {
    echo json_encode(['status' => 0, 'message' => 'Invalid user ID']);
    exit;
}

// Prevent following yourself
if ($_SESSION['id'] == $user_id) {
    echo json_encode(['status' => 0, 'message' => 'You cannot follow yourself']);
    exit;
}

// Toggle follow status
$Obj = new logics();
$result = $Obj->toggleFollow($_SESSION['id'], $user_id);

// Return result
echo json_encode($result);
exit;