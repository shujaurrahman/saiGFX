<?php
session_start(); // Add this at the very top
include_once("includes/debug.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once "includes/links.php";
?>

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

        <!-- Project-listing -->
        <?php
        include_once "components/project-listing.php"
            ?>

    </main>
    <!-- main end -->
    <!-- footer start -->
    <?php
    include_once "includes/footer.php"
        ?>
    <!-- footer end -->
    <!-- footer-copyright start -->
    <?php
    // include_once "includes/footer-copyright.php";
    ?>
    <!-- footer-copyright end -->
    <!-- vega-mobile start -->
    <?php
    include_once "includes/side-mobilecategory.php";
    ?>
    <!-- vega-mobile end -->
    <!-- mobile-menu start -->
    <?php
    include_once "includes/mobile-menu.php";
    ?>
    <!-- mobile-menu end -->
    <!-- search-modal start -->
    <?php
    include_once "includes/search.php";
    ?>
    <!-- cart-drawer start -->
    <?php
    // include_once "includes/cart-drawer.php";
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
    <!-- bottom-menu start -->
    <?php
    include_once "includes/bottom-menu.php";
    ?>
    <!-- bottom-menu end -->
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

<!-- Mirrored from spacingtech.com/html/electon/electon/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 25 Dec 2024 06:29:24 GMT -->

</html>