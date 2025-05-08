<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("includes/debug.php")
?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once "includes/links.php";
?>
<style>
    .text-primary{
        color:#fcba05 !important;
    }
    .category-badge{
        color:#fcba05 !important;

    }
    .category-badge:hover{
        color: white !important;
        background-color: #fcba05 !important;
    }
</style>

<body>
    <!-- notification-bar start -->
    <?php
    include_once "includes/banner.php"
        ?>
    <!-- notification-bar end -->
    <!-- header start -->
    <?php
    include_once "includes/header.php";
    ?>
    <!-- header end -->
    <!-- main start -->
    <main id="main-content">
        <!-- slider-area start-->
         
        <?php
        include_once "components/slider-add.php"
            ?>
        <!-- slider-area end -->
        <!-- category start -->
        <?php
        // include_once "components/slider-category.php"
            ?>
        <!-- category end -->
        <!-- banner-grid start -->
        <?php
        // include_once "components/banner-add.php"
            ?>
        <!-- banner-grid end -->
        <!-- our-service start -->
        <?php
        // include_once "components/services.php"
            ?>
        <!-- our-service end -->
        <!-- product-tranding start -->
        <?php
        include_once "products/trending-product.php"
            ?>
        <!-- product-tranding end -->
        <!-- deal-day start -->
        <?php
        // include_once "components/dod-add.php"
            ?>
        <!-- deal-day end -->
        <!-- test-area start -->
        <?php
        // include_once "components/testimonials.php"
            ?>
        <!-- test-area end -->
        <!-- product-Featured  start -->
        <?php
        include_once "products/product-featured.php"
            ?>
        <!-- product-Featured end -->
        <?php
        if (isset($_SESSION['id'])) {
            include_once "products/followed-projects.php";
        }
        ?>

        <!-- Category-wise Products Section -->
        <?php
        include_once "products/category-products.php";
        ?>

        <!-- Featured Authors Section -->
        <?php
        include_once "components/authors-slider.php";
        ?>

        <!-- instagram-area start -->
        <?php
        // include_once "components/insta.php"
            ?>
        <!-- instagram-area end -->
        <!-- brand-logo start -->
        <?php
        // include_once "components/brands-logo.php"
            ?>
        <!-- brand-logo end -->
    </main>
    <!-- main end -->
    <!-- footer start -->
    <?php
    include_once "includes/footer.php";
        include_once "includes/footer-copyright.php";

        ?>
    <!-- footer end -->



    <!-- cart-drawer start -->
    <?php
    include_once "includes/cart-drawer.php";
    ?>
    <!-- cart-drawer end -->
    <!-- quickview modal start -->
    <?php
    include_once "products/productmodal.php";
    ?>
    <!-- quickview modal end -->
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
        $('.authors-slider').owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsive:{
                0:{
                    items: 1
                },
                576:{
                    items: 2
                },
                768:{
                    items: 3
                },
                992:{
                    items: 4
                }
            },
            navText: [
                '<i class="feather-chevron-left"></i>',
                '<i class="feather-chevron-right"></i>'
            ]
        });
    });
    </script>
</body>

<!-- Mirrored from spacingtech.com/html/electon/electon/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 25 Dec 2024 06:29:24 GMT -->

</html>