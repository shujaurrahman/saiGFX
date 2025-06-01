<?php
// Add error logging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Check if order exists and belongs to user
if (!isset($orderData['status']) || $orderData['user_id'] != $_SESSION['id']) {
    header('Location: cart.php');
    exit;
}

// Check if order is paid
if (strtolower($orderData['payment_status']) !== 'paid') {
    header('Location: order-success.php?order_id=' . $_GET['order_id']);
    exit;
}

// Get order items
$orderItems = $Obj->getOrderItems($_GET['order_id']);

if (!isset($orderItems['status']) || $orderItems['status'] != 1) {
    die("No items found in this order.");
}

// Function to sanitize filename
function sanitizeFilename($filename) {
    return preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
}

// Function to get file extension
function getFileExtension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

// Function to get mime type
function getMimeType($extension) {
    $mimeTypes = [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'svg' => 'image/svg+xml'
    ];
    
    return isset($mimeTypes[$extension]) ? $mimeTypes[$extension] : 'application/octet-stream';
}

// If it's a single file download
if (isset($_GET['file'])) {
    $fileIndex = (int)$_GET['file'];
    if (isset($orderItems['file_path'][$fileIndex])) {
        $filePath = $orderItems['file_path'][$fileIndex];
        $fileName = $orderItems['file_name'][$fileIndex];
        
        // Sanitize filename
        $fileName = sanitizeFilename($fileName);
        $extension = getFileExtension($fileName);
        
        // Set headers for download
        header('Content-Type: ' . getMimeType($extension));
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: private');
        header('Pragma: private');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        
        // Output file
        readfile($filePath);
        exit;
    }
}

// If it's a zip download of all files
if (isset($_GET['all'])) {
    // Create a temporary zip file
    $zipFile = tempnam(sys_get_temp_dir(), 'download_');
    $zip = new ZipArchive();
    
    if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
        // Add each file to the zip
        for ($i = 0; $i < $orderItems['count']; $i++) {
            if (isset($orderItems['file_path'][$i]) && file_exists($orderItems['file_path'][$i])) {
                $fileName = sanitizeFilename($orderItems['file_name'][$i]);
                $zip->addFile($orderItems['file_path'][$i], $fileName);
            }
        }
        
        $zip->close();
        
        // Set headers for zip download
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="order_' . $_GET['order_id'] . '_files.zip"');
        header('Cache-Control: private');
        header('Pragma: private');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        
        // Output zip file
        readfile($zipFile);
        
        // Delete temporary zip file
        unlink($zipFile);
        exit;
    }
}

// If no specific download request, show download page
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once "includes/links.php"; ?>

<head>
    <style>
        .download-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 40px 20px;
        }
        
        .download-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .download-list {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }
        
        .download-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .download-item:last-child {
            border-bottom: none;
        }
        
        .file-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .file-icon {
            font-size: 24px;
            color: #666;
        }
        
        .file-name {
            font-weight: 500;
            color: #333;
        }
        
        .download-btn {
            background: #fcba05;
            color: #fff;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .download-btn:hover {
            background: #e5a800;
            transform: translateY(-2px);
        }
        
        .download-all {
            text-align: center;
            margin-top: 30px;
        }
        
        .download-all .download-btn {
            padding: 12px 30px;
            font-size: 1.1em;
        }
    </style>
</head>

<body>
    <?php include_once "includes/banner.php"; ?>
    <?php include_once "includes/header.php"; ?>

    <main id="main-content">
        <div class="download-container">
            <div class="download-header">
                <h1>Download Your Files</h1>
                <p>Order #<?php echo htmlspecialchars($orderData['id']); ?></p>
            </div>
            
            <div class="download-list">
                <?php for ($i = 0; $i < $orderItems['count']; $i++): ?>
                    <div class="download-item">
                        <div class="file-info">
                            <i class="fas fa-file file-icon"></i>
                            <span class="file-name"><?php echo htmlspecialchars($orderItems['file_name'][$i]); ?></span>
                        </div>
                        <a href="download.php?order_id=<?php echo htmlspecialchars($_GET['order_id']); ?>&file=<?php echo $i; ?>" 
                           class="download-btn">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                <?php endfor; ?>
            </div>
            
            <?php if ($orderItems['count'] > 1): ?>
                <div class="download-all">
                    <a href="download.php?order_id=<?php echo htmlspecialchars($_GET['order_id']); ?>&all=1" 
                       class="download-btn">
                        <i class="fas fa-download"></i> Download All Files (ZIP)
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include_once "includes/footer.php"; ?>
</body>
</html> 