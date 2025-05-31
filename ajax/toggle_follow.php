<?php
session_start();
require_once('../logics.class.php');

// Send JSON header
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 0, 'message' => 'You must be logged in to follow users']);
    exit;
}

// Get user ID from POST
$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

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