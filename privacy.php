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
                            <li class="breadcrumb-item active">Privacy Policy</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <section class="privacy-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="privacy-content bg-white p-4 rounded shadow-sm">
                            <h1 class="mb-4">Privacy Policy</h1>
                            <p>Last updated: May 25, 2025</p>
                            
                            <div class="mb-4">
                                <h4>1. Information We Collect</h4>
                                <p>We collect personal information such as name, email address, and payment details when you register or make a purchase.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>2. How We Use Your Information</h4>
                                <p>We use your information to process transactions, provide customer support, and improve our services.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>3. Information Sharing</h4>
                                <p>We do not sell or rent your personal information to third parties. We may share information with service providers who help us operate our business.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>4. Cookies</h4>
                                <p>We use cookies to enhance your browsing experience and collect usage information to improve our services.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>5. Data Security</h4>
                                <p>We implement appropriate security measures to protect your personal information from unauthorized access or disclosure.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>6. Your Rights</h4>
                                <p>You have the right to access, correct, or delete your personal information. You may also object to certain processing of your data.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>7. Contact Us</h4>
                                <p>If you have any questions about this Privacy Policy, please contact us at <a href="mailto:privacy@saigfx.com">privacy@saigfx.com</a>.</p>
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