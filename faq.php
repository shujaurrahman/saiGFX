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
                            <li class="breadcrumb-item active">FAQ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <section class="faq-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="faq-header text-center mb-5">
                            <h1>Frequently Asked Questions</h1>
                            <p>Find answers to common questions about our products and services.</p>
                        </div>
                        
                        <div class="faq-content bg-white p-4 rounded shadow-sm">
                            <div class="accordion" id="faqAccordion">
                                <!-- Question 1 -->
                                <div class="accordion-item mb-3 border">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            What formats do your digital products come in?
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Our products typically come in ZIP format containing all necessary files. Depending on the product type, you may receive PSD, AI, PDF, or other format files. Each product page specifies the exact formats included.
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Question 2 -->
                                <div class="accordion-item mb-3 border">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            How do I download my purchased products?
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            After completing your purchase, you can download your products from your account dashboard. Navigate to "My Purchases" to see all your bought items. Each product will have a download button.
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Question 3 -->
                                <div class="accordion-item mb-3 border">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            What is your license policy?
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Our standard license allows you to use the product for personal or commercial projects. You cannot redistribute or resell the product as-is. For more details, please refer to our <a href="terms.php">Terms of Service</a>.
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Question 4 -->
                                <div class="accordion-item mb-3 border">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            Can I get a refund if I'm not satisfied?
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Due to the digital nature of our products, we generally don't offer refunds once the product has been downloaded. However, if there's a technical issue with the product, please contact our support team. See our <a href="refund.php">Refund Policy</a> for more information.
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Question 5 -->
                                <div class="accordion-item mb-3 border">
                                    <h2 class="accordion-header" id="headingFive">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            How do I contact customer support?
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            You can reach our customer support team by emailing <a href="mailto:support@saigfx.com">support@saigfx.com</a> or through our <a href="contact.php">Contact Page</a>. We typically respond within 24-48 hours during business days.
                                        </div>
                                    </div>
                                </div>
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