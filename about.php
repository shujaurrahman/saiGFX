<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
                            <li class="breadcrumb-item active">About Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb end -->
        
        <!-- about-us banner section start -->
        <section class="about-banner-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="about-banner-content">
                            <h1 class="about-title">We're Building Digital Products For Designers & Developers</h1>
                            <p class="about-description">SaiGFX is a premium digital asset marketplace that provides high-quality design resources, templates, and tools for creative professionals around the world.</p>
                            <div class="about-stats">
                                <div class="row">
                                    <div class="col-6 col-md-3">
                                        <div class="stat-item">
                                            <h3>5K+</h3>
                                            <p>Products</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="stat-item">
                                            <h3>50K+</h3>
                                            <p>Downloads</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="stat-item">
                                            <h3>10K+</h3>
                                            <p>Customers</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="stat-item">
                                            <h3>100+</h3>
                                            <p>Countries</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-banner-image">
                            <img src="panels/admin/uploads/profile/profile_1746619032_3.jpg" alt="About SaiGFX" class="img-fluid rounded shadow-lg">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about-us banner section end -->
        
        <!-- our mission section start -->
        <section class="mission-section section-ptb bg-light-grey">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center mb-5">
                        <div class="section-header">
                            <h2 class="section-title">Our Mission & Vision</h2>
                            <p class="section-description">We're on a mission to empower creatives by providing the tools they need to bring their ideas to life.</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="mission-card">
                            <div class="mission-icon">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <h3>Our Mission</h3>
                            <p>To create a platform where designers and developers can find high-quality, ready-to-use resources that save time and boost productivity. We aim to democratize design by making professional tools accessible to everyone.</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="mission-card">
                            <div class="mission-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h3>Our Vision</h3>
                            <p>To become the leading global marketplace for digital assets, known for exceptional quality, innovative products, and a community where creators can share, learn, and grow together.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- our mission section end -->
        
        <!-- our story section start -->
        <section class="story-section section-ptb">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 order-2 order-lg-1">
                        <div class="story-content">
                            <h2>Our Story</h2>
                            <p>SaiGFX started with a simple idea: to create a platform where designers could find high-quality resources without spending hours searching across the web.</p>
                            <p>Founded in 2020 by a team of designers and developers who understood the challenges of the creative process, we set out to build a marketplace that would become the go-to resource for digital assets.</p>
                            <p>What began as a small collection of templates has grown into a comprehensive library of thousands of products, serving customers in over 100 countries. Along the way, we've stayed true to our core values of quality, innovation, and customer satisfaction.</p>
                            <p>Today, we continue to expand our offerings and improve our platform, driven by feedback from our growing community of users. Our journey is just beginning, and we're excited about the road ahead.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4 mb-lg-0 order-1 order-lg-2">
                        <div class="story-image">
                            <img src="panels/admin/uploads/profile/profile_1746619032_3.jpg" alt="Our Story" class="img-fluid rounded shadow-lg">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- our story section end -->
        

        

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
    
    <script>
        $(document).ready(function(){
            // Initialize the testimonial carousel
            $(".testimonial-carousel").owlCarousel({
                items: 3,
                loop: true,
                margin: 30,
                nav: false,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                smartSpeed: 1000,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    }
                }
            });
        });
    </script>
</body>
</html>