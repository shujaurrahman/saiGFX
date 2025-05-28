<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

require_once('logics.class.php');
$Obj = new logics();

try {
    // Create order in database
    $orderData = [
        'user_id' => $_SESSION['id'],
        'razorpay_payment_id' => $_POST['razorpay_payment_id'],
        'amount' => $_POST['amount'],
        'status' => 'completed',
        'payment_status' => 'paid',
        'billing_name' => $_POST['name'],
        'billing_email' => $_POST['email'],
        'billing_phone' => $_POST['phone'],
        'billing_address' => $_POST['address'],
        'created_at' => date('Y-m-d H:i:s')
    ];

    $orderId = $Obj->createOrder($orderData);
    
    if ($orderId) {
        // Get cart items and create order items
        $cartItems = $Obj->getCartById($_SESSION['id']);
        if (!empty($cartItems['cart_items'])) {
            foreach ($cartItems['cart_items'] as $item) {
                $orderItemData = [
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'price' => $item['discounted_price'] ?? $item['product_price']
                ];
                $result = $Obj->addOrderItem($orderItemData);
                if (!$result['status']) {
                    throw new Exception('Failed to add order item');
                }

                // Record the sale directly using cart item data
                $saleData = [
                    'product_id' => $item['product_id'],
                    'seller_id' => $item['uploader_id'],
                    'buyer_id' => $_SESSION['id'],
                    'amount' => $item['discounted_price'] ?? $item['product_price'],
                    'commission_rate' => 0.00, // Set commission to 0
                    'payment_status' => 'completed'
                ];

                error_log("Recording sale for product: " . $saleData['product_id']);
                $saleResult = $Obj->recordSale($saleData);
                if (!$saleResult['status']) {
                    error_log("Failed to record sale: " . ($saleResult['message'] ?? 'Unknown error'));
                }
            }
            
            // Clear cart only after all items are processed
            $clearResult = $Obj->clearCart($_SESSION['id']);
            if (!$clearResult['status']) {
                error_log('Failed to clear cart: ' . ($clearResult['error'] ?? 'Unknown error'));
            }
            
            // Return success with order ID for redirection
            echo json_encode([
                'status' => 'success',
                'order_id' => $orderId,
                'message' => 'Order placed successfully'
            ]);
            exit;
        }
    }
    
    throw new Exception('Failed to create order');

} catch (Exception $e) {
    error_log('Order processing error: ' . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}