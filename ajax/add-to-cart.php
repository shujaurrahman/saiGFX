<?php

session_start();
require_once('../logics.class.php');

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode([
        'status' => 0,
        'message' => 'Please login first'
    ]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$Obj = new logics();
$result = $Obj->addToCart($_SESSION['id'], $data['product_id'], 1);

echo json_encode($result);