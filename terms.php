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
                            <li class="breadcrumb-item active">Terms of Service</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <section class="terms-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="terms-content bg-white p-4 rounded shadow-sm">
                            <h1 class="mb-4">Terms of Service</h1>
                            <p>Last updated: May 25, 2025</p>
                            
                            <div class="mb-4">
                                <h4>1. Acceptance of Terms</h4>
                                <p>By accessing and using SaiGFX services, you agree to be bound by these Terms of Service.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>2. Account Registration</h4>
                                <p>To access certain features, you must register for an account. You agree to provide accurate information and keep it updated.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>3. Licensing Terms</h4>
                                <p>When you purchase a product, you're granted a non-exclusive license to use the digital asset according to the license type selected at purchase.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>4. User Conduct</h4>
                                <p>You agree not to use our services for any illegal purposes or in violation of any applicable laws.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>5. Intellectual Property</h4>
                                <p>All content and materials available on SaiGFX are owned by us or our licensors and are protected by copyright, trademark, and other intellectual property laws.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>6. Termination</h4>
                                <p>We reserve the right to terminate or suspend your account and access to our services at our sole discretion, without notice, for conduct that we believe violates these Terms or is harmful to other users.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>7. Changes to Terms</h4>
                                <p>We may modify these terms at any time. It is your responsibility to review these terms periodically.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4>8. Contact Information</h4>
                                <p>If you have any questions about these Terms, please contact us at <a href="mailto:support@saigfx.com">support@saigfx.com</a>.</p>
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