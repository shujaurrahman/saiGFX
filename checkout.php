<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: panels/admin/login.php');
    exit;
}

// Check if cart is empty
if (!class_exists('logics')) {
    require_once('logics.class.php');
}
$Obj = new logics();
$cartItems = $Obj->getCartById($_SESSION['id']);

if (!isset($cartItems['count']) || $cartItems['count'] < 1) {
    header('Location: cart.php');
    exit;
}

include_once("includes/debug.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once "includes/links.php"; ?>
<!-- Add Razorpay SDK -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<body>
    <?php include_once "includes/banner.php"; ?>
    <?php include_once "includes/header.php"; ?>
    
    <main id="main-content">
        <?php include_once "components/checkout.php"; ?>
    </main>
    
    <?php include_once "includes/side-mobilecategory.php"; ?>
    <?php include_once "includes/mobile-menu.php"; ?>
    <?php include_once "includes/search.php"; ?>
    <?php include_once "includes/cart-drawer.php"; ?>
    
    <div class="bg-screen"></div>
    <?php include_once "includes/bottom-menu.php"; ?>
    
    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>