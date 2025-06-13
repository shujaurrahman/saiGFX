<?php
// Add error logging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();
require_once('logics.class.php');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: panels/admin/login.php');
    exit;
}

// Check if order ID is provided
if (!isset($_GET['order_id'])) {
    header('Location: cart.php');
    exit;
}

$Obj = new logics();
$orderData = $Obj->getOrderById($_GET['order_id']);

// Debug output
error_log("Order Data: " . print_r($orderData, true));

// Check if order exists and belongs to user
if (!isset($orderData['status']) || $orderData['user_id'] != $_SESSION['id']) {
    error_log("Order validation failed: " . print_r($orderData, true));
    header('Location: cart.php');
    exit;
}

// Calculate total amount from order items if not set
if (!isset($orderData['total_amount'])) {
    $orderData['total_amount'] = isset($orderData['amount']) ? $orderData['amount'] : 0;
}

// Format the date
$orderDate = isset($orderData['created_at']) ? date('d M Y, h:i A', strtotime($orderData['created_at'])) : date('d M Y, h:i A');

// Get payment status with default
$paymentStatus = isset($orderData['payment_status']) ? ucfirst($orderData['payment_status']) : 'Pending';

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once "includes/links.php"; ?>

<head>
    <style>
        .success-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 40px 20px;
            text-align: center;
        }

        .success-icon {
            color: #28a745;
            font-size: 64px;
            margin-bottom: 20px;
        }

        .success-message h1 {
            color: #333;
            margin-bottom: 15px;
        }

        .order-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 30px 0;
            text-align: left;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            color: #333;
            font-weight: 600;
        }

        .download-btn {
            background: #fcba05;
            color: #fff;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .download-btn:hover {
            background: #e5a800;
            transform: translateY(-2px);
        }

        .print-btn {
            background: #4a90e2;
            color: #fff;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            margin-left: 10px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .print-btn:hover {
            background: #357abd;
            transform: translateY(-2px);
        }

        @media print {
            .download-btn, .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <?php include_once "includes/banner.php"; ?>
    <?php include_once "includes/header.php"; ?>

    <main id="main-content">
        <div class="success-container">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="success-message">
                <h1>Thank You!</h1>
                <p>Your order has been placed successfully.</p>
                
                <div class="order-details">
                    <div class="detail-row">
                        <span class="detail-label">Order ID:</span>
                        <span class="detail-value">#<?php echo htmlspecialchars($orderData['id']); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Amount Paid:</span>
                        <span class="detail-value">₹<?php echo number_format((float)$orderData['total_amount'], 2); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Payment Status:</span>
                        <span class="detail-value"><?php echo $paymentStatus; ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Date:</span>
                        <span class="detail-value"><?php echo $orderDate; ?></span>
                    </div>
                </div>

                <?php if (strtolower($paymentStatus) === 'paid'): ?>
                <a href="download.php?order_id=<?php echo htmlspecialchars($orderData['id']); ?>" class="download-btn">
                    <i class="fas fa-download"></i> Download Files
                </a>
                <?php endif; ?>
                
                <button onclick="printOrderDetails()" class="print-btn">
                    <i class="fas fa-print"></i> Print Order Details
                </button>
            </div>
        </div>
    </main>

    <?php include_once "includes/footer.php"; ?>

    <script>
    function printOrderDetails() {
        // Create a new window for printing
        const printWindow = window.open('', '_blank');
        
        // Get the order details
        const orderDetails = document.querySelector('.order-details').innerHTML;
        
        // Create the print content
        const printContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Order Details - #${<?php echo json_encode($orderData['id']); ?>}</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        padding: 20px;
                        max-width: 800px;
                        margin: 0 auto;
                    }
                    .print-header {
                        text-align: center;
                        margin-bottom: 30px;
                    }
                    .print-header h1 {
                        color: #333;
                        margin-bottom: 10px;
                    }
                    .detail-row {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 10px;
                        padding: 10px 0;
                        border-bottom: 1px solid #eee;
                    }
                    .detail-label {
                        color: #666;
                        font-weight: 500;
                    }
                    .detail-value {
                        color: #333;
                        font-weight: 600;
                    }
                    .print-footer {
                        margin-top: 30px;
                        text-align: center;
                        color: #666;
                        font-size: 12px;
                    }
                    @media print {
                        body {
                            padding: 0;
                        }
                        .print-header {
                            margin-bottom: 20px;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="print-header">
                    <h1>Order Details</h1>
                    <p>Thank you for your purchase!</p>
                </div>
                ${orderDetails}
                <div class="print-footer">
                    <p>This is a computer-generated document. No signature is required.</p>
                    <p>Printed on: ${new Date().toLocaleString()}</p>
                </div>
            </body>
            </html>
        `;
        
        // Write the content to the new window
        printWindow.document.write(printContent);
        printWindow.document.close();
        
        // Wait for content to load then print
        printWindow.onload = function() {
            printWindow.print();
            // Close the window after printing
            printWindow.onafterprint = function() {
                printWindow.close();
            };
        };
    }
    </script>

</body>
</html>