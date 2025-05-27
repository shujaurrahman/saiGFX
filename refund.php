<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once "includes/links.php"; ?>

<body>
    <?php include_once "includes/banner.php"; ?>
    <?php include_once "includes/header.php"; ?>
    
    <main id="main-content">
        <div class="breadcrumb-area bg-light-grey">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Refund Policy</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <section class="refund-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="refund-content bg-white p-4 rounded shadow-sm">
                            <h1 class="mb-4">Refund Policy</h1>
                            <p>Last updated: May 25, 2025</p>
                            
                            <div class="mb-4">
                                <h4>1. Digital Products</h4>
                                <p>Due to the nature of digital products, all sales are final and non-refundable once the download link has been accessed.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>2. Exceptions for Refunds</h4>
                                <p>We may consider refunds in the following circumstances:</p>
                                <ul>
                                    <li>The product is defective or doesn't function as described</li>
                                    <li>You were charged multiple times for the same product</li>
                                    <li>You haven't downloaded or accessed the product</li>
                                </ul>
                            </div>
                            
                            <div class="mb-4">
                                <h4>3. How to Request a Refund</h4>
                                <p>To request a refund, please contact our support team at <a href="mailto:support@saigfx.com">support@saigfx.com</a> within 7 days of purchase with your order number and reason for the refund.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>4. Refund Processing</h4>
                                <p>Approved refunds will be processed within 5-7 business days to the original payment method.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <?php
    include_once "includes/footer.php";
    include_once "includes/footer-copyright.php";
    include_once "includes/cart-drawer.php";
    ?>
    
    <div class="bg-screen"></div>
    
    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>