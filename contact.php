<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('./logics.class.php');
$Obj = new logics();

// Handle form submission
$message = '';
$messageType = '';
$name = $email = $mobile = $userMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    // Validate form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $userMessage = trim($_POST['message']);
    
    // Simple validation
    if (empty($name) || empty($email) || empty($mobile) || empty($userMessage)) {
        $message = 'Please fill in all fields';
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address';
        $messageType = 'error';
    } else {
        // Submit contact form using the logic class method
        $result = $Obj->submitContactForm($name, $email, $mobile, $userMessage);
        
        if ($result['status'] == 1) {
            $message = $result['message'];
            $messageType = 'success';
            // Clear form data after successful submission
            $name = $email = $mobile = $userMessage = '';
        } else {
            $message = $result['message'];
            $messageType = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
include_once "includes/links.php";
?>

<body>
    <!-- notification-bar start -->
    <?php include_once "includes/banner.php"; ?>
    <!-- notification-bar end -->
    
    <!-- header start -->
    <?php include_once "includes/header.php"; ?>
    <link rel="stylesheet" href="css/contact-about.css">
    <!-- header end -->
    
    <!-- main start -->
    <main id="main-content">
        <!-- breadcrumb start -->
        <div class="breadcrumb-area bg-light-grey">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Contact Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb end -->
        
        <!-- contact section start -->
        <section class="contact-section section-ptb">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-lg-8 mx-auto text-center">
                        <div class="section-header">
                            <h2 class="section-title">Get In Touch</h2>
                            <p class="section-description">We'd love to hear from you! Whether you have a question about our products, need technical support, or want to collaborate, our team is ready to help.</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-5 mb-4 mb-lg-0">
                        <div class="contact-info-wrapper">
                            <div class="contact-info-box">
                                <div class="contact-info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-info-content">
                                    <h4>Our Location</h4>
                                    <p>123 Digital Avenue, Tech Park</p>
                                    <p>New Delhi, India 110001</p>
                                </div>
                            </div>
                            
                            <div class="contact-info-box">
                                <div class="contact-info-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="contact-info-content">
                                    <h4>Phone Number</h4>
                                    <p><a href="tel:+919876543210">+91 9876 543 210</a></p>
                                    <p><a href="tel:+911123456789">+91 11 2345 6789</a></p>
                                </div>
                            </div>
                            
                            <div class="contact-info-box">
                                <div class="contact-info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-info-content">
                                    <h4>Email Address</h4>
                                    <p><a href="mailto:info@saigfx.com">info@saigfx.com</a></p>
                                    <p><a href="mailto:support@saigfx.com">support@saigfx.com</a></p>
                                </div>
                            </div>
                            
                            <div class="contact-info-box">
                                <div class="contact-info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="contact-info-content">
                                    <h4>Working Hours</h4>
                                    <p>Monday - Friday: 9 AM - 6 PM</p>
                                    <p>Saturday: 10 AM - 4 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-7">
                        <div class="contact-form-wrapper">
                            <h3>Send Us a Message</h3>
                            
                            <?php if (!empty($message)): ?>
                                <div class="alert alert-<?php echo $messageType === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                                    <?php echo $message; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="contact-form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name">Your Name <span class="required">*</span></label>
                                            <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Email Address <span class="required">*</span></label>
                                            <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="mobile">Phone Number <span class="required">*</span></label>
                                            <input type="tel" id="mobile" name="mobile" class="form-control" value="<?php echo isset($mobile) ? htmlspecialchars($mobile) : ''; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="message">Your Message <span class="required">*</span></label>
                                            <textarea id="message" name="message" class="form-control" rows="5" required><?php echo isset($userMessage) ? htmlspecialchars($userMessage) : ''; ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <button type="submit" name="contact_submit" class="btn btn-primary">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact section end -->
        
        <!-- map section start -->
        <section class="map-section">
            <div class="container-fluid p-0">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3504.2536055556534!2d77.20659611508092!3d28.56614068244333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce26f903969d7%3A0x8467b9a86dabf5a4!2sAIIMS%20Delhi!5e0!3m2!1sen!2sin!4v1621512626401!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </section>
        <!-- map section end -->
    </main>
    <!-- main end -->
    
    <!-- footer start -->
    <?php
    include_once "includes/footer.php";
    include_once "includes/footer-copyright.php";
    ?>
    <!-- footer end -->
    
    <!-- cart-drawer start -->
    <?php include_once "includes/cart-drawer.php"; ?>
    <!-- cart-drawer end -->
    
    <!-- bg-scren start -->
    <div class="bg-screen"></div>
    <!-- bg-scren end -->
    
    <!-- jquery js -->
    <script src="js/jquery-3.6.3.min.js"></script>
    <!-- bootstrap js -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- magnific-popup js -->
    <script src="js/jquery.magnific-popup.min.js"></script>
    <!-- owl-carousel js -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- swiper-slider js -->
    <script src="js/swiper-bundle.min.js"></script>
    <!-- slick js -->
    <script src="js/slick.min.js"></script>
    <!-- waypoints js -->
    <script src="js/waypoints.min.js"></script>
    <!-- counter js -->
    <script src="js/counter.js"></script>
    <!-- main js -->
    <script src="js/main.js"></script>
</body>
</html>