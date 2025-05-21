<?php

require_once('./logics.class.php');
include_once "includes/links.php";

// Create utility functions in a helper file
require_once("includes/itemhelper.php");

// Main execution flow
$Obj = new logics();
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// Get product details from logics class
$product = $Obj->getProductBySlug($slug);

// If product not found, redirect to homepage
if (empty($product)) {
    header('Location: index.php');
    exit;
}

// Extract YouTube video ID if available
$videoId = !empty($product['youtube_url']) ? $Obj->extractYoutubeId($product['youtube_url']) : '';

// In your item.php, before the reviews section
$ratings = $Obj->getProductRatings($product['id']);

// Add this right before checking if user has purchased the product
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



// Check if user has purchased this product
$userHasPurchased = false;
if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {

    
    // Call a method from your logics class to check purchase status
    $userHasPurchased = $Obj->hasUserPurchasedProduct($_SESSION['id'], $product['id']);

} else {
    error_log("User is not logged in or session ID is not set");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?> - Digital Library</title>
    <meta name="description" content="<?php echo htmlspecialchars(substr($product['short_description'] ?? '', 0, 160)); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="css/item.css">
<link rel="stylesheet" href="css/item-responsive.css">
    <link rel="stylesheet" href="css/loading.css">
</head>

<body>
    <div class="page-wrapper">
        <!-- notification-bar start -->
        <?php include_once "includes/banner.php"; ?>
        <!-- notification-bar end -->
        
        <!-- header start -->
        <?php include_once "includes/header.php"; ?>
        <!-- header end -->

        <!-- main content wrapper -->
        <div class="main-content-wrapper">
            <div class="container">
                <div class="product-view-container">
                    <!-- Product Image Section -->
                    <div class="product-image-wrapper">
                        <?php echo renderImageGallery($product); ?>
                    </div>
                    
                    <!-- Product Details Section -->
                    <div class="product-info">
                        <h1 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h1>
                        
                        <!-- Add ratings display here -->
                        <div class="product-rating">
                            <div class="rating-stars">
                                <?php
                                $rating = $ratings['average'];
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= floor($rating)) {
                                        echo '<i class="fas fa-star"></i>';
                                    } elseif ($i - $rating < 1) {
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                            <div class="rating-text">
                                <span class="rating-value"><?php echo number_format($rating, 1); ?></span>
                                <span class="rating-count">(<?php echo $ratings['total_reviews']; ?> reviews)</span>
                            </div>
                        </div>
                        
                        <?php if (!empty($product['short_description'])): ?>
                        <p class="short-description"><?php echo htmlspecialchars($product['short_description']); ?></p>
                        <?php endif; ?>
                        
                        <?php echo renderPricingSection($product, $userHasPurchased); ?>
                        
                        <?php echo renderFileFormatBadges($product); ?>
                        
                        <!-- Updated author-section with buttons next to author name -->
                        <div class="author-section">
                            <div class="card">
                                <div class="card-body">
                                    <div class="author-container">
                                        <div class="author-info-wrapper">
                                            <div class="author-avatar">
                                                <?php if (!empty($product['uploader_profile_img'])): ?>
                                                    <img src="./panels/admin/uploads/profile/<?php echo htmlspecialchars($product['uploader_profile_img']); ?>" 
                                                         alt="<?php echo htmlspecialchars($product['uploader_name']); ?>">
                                                <?php else: ?>
                                                    <img src="./panels/assets/img/avatars/1.png" 
                                                         alt="Default Profile">
                                                <?php endif; ?>
                                            </div>
                                            <div class="author-info">
                                                <div class="author-name-wrapper">
                                                    <h5>
                                                        <a href="userProfile.php?id=<?php echo $product['uploader_id']; ?>">
                                                            <?php echo htmlspecialchars($product['uploader_name']); ?>
                                                        </a>
                                                    </h5>
                                                    
                                                    <!-- Move Action Buttons here -->
                                                    <div class="author-actions">
                                                        <?php if (isset($_SESSION['id'])): ?>
                                                            <?php if ($_SESSION['id'] != $product['uploader_id']): ?>
                                                                <?php
                                                                $isFollowing = false;
                                                                if (method_exists($Obj, 'isFollowing')) {
                                                                    $isFollowing = $Obj->isFollowing($_SESSION['id'], $product['uploader_id']);
                                                                }
                                                                ?>
                                                                <button id="followButton" class="follow-btn" data-user-id="<?php echo $product['uploader_id']; ?>">
                                                                    <i class="fas fa-<?php echo $isFollowing ? 'check' : 'user-plus'; ?>"></i> 
                                                                    <?php echo $isFollowing ? 'Following' : 'Follow'; ?>
                                                                </button>
                                                            <?php else: ?>
                                                                <a href="./panels/admin/myProfile.php" class="edit-profile-btn">
                                                                    <i class="fas fa-edit"></i> Edit Profile
                                                                </a>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <a href="./panels/admin/login.php" class="login-follow-btn">
                                                                <i class="fas fa-sign-in-alt"></i> Login to Follow
                                                            </a>
                                                        <?php endif; ?>
                                                        <!-- <a href="userProfile.php?id=<?php echo $product['uploader_id']; ?>" class="profile-btn">
                                                            <i class="fas fa-user-circle"></i> Profile
                                                        </a> -->
                                                    </div>
                                                </div>
                                                
                                                <!-- Horizontal Author Stats -->
                                                <div class="author-stats">
                                                    <div class="author-stat">
                                                        <div class="stat-content">
                                                            <i class="fas fa-box"></i>
                                                            <div class="stat-text">
                                                                <span class="stat-value"><?php echo number_format($product['uploader_items'] ?? 0); ?></span>
                                                                <span class="stat-label">Items</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="author-stat">
                                                        <div class="stat-content">
                                                            <i class="fas fa-user"></i>
                                                            <div class="stat-text">
                                                                <span class="stat-value"><?php echo number_format($product['uploader_followers'] ?? 0); ?></span>
                                                                <span class="stat-label">Followers</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="author-stat">
                                                        <div class="stat-content">
                                                            <i class="fas fa-star"></i>
                                                            <div class="stat-text">
                                                                <span class="stat-value"><?php echo number_format($product['uploader_rating'] ?? 0, 1); ?></span>
                                                                <span class="stat-label">Rating</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="author-since">Member since <?php echo date('M Y', strtotime($product['uploader_joined'] ?? 'now')); ?></p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-value"><?php echo number_format($product['views']); ?></div>
                                <div class="stat-label">Views</div>
                            </div>
                            <div class="stat-item">
                                <?php 
                                // Get total purchases for this specific product
                                $totalPurchases = $Obj->getTotalPurchases($product['id']);
                                ?>
                                <div class="stat-value"><?php echo number_format($totalPurchases); ?></div>
                                <div class="stat-label">Purchases</div>
                            </div>
                        </div>
                        
                        <div class="info-section">
                            <div class="info-row">
                                <div class="info-label">Released</div>
                                <div class="info-value"><?php echo $product['formatted_created_date']; ?></div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Last Updated</div>
                                <div class="info-value"><?php echo $product['formatted_updated_date']; ?></div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Category</div>
                                <div class="info-value"><?php echo htmlspecialchars($product['category_name']); ?></div>
                            </div>
                            
                            <?php if (!empty($product['subcategories'])): ?>
                            <div class="info-row">
                                <div class="info-label">Type</div>
                                <div class="info-value">
                                    <?php 
                                    $subcatNames = [];
                                    $subcategories = isset($product['subcategories']) && is_array($product['subcategories']) ? $product['subcategories'] : [];
                                    if (!empty($subcategories)) {
                                        $currentSubcats = array_filter($subcategories, function($subcat) use ($product) {
                                            $productSubcatIds = explode(',', $product['subcategory_id']);
                                            return in_array($subcat['id'], $productSubcatIds);
                                        });
                                        $subcatNames = array_map(function($subcat) {
                                            return htmlspecialchars($subcat['name']);
                                        }, $currentSubcats);
                                    }
                                    echo implode(', ', $subcatNames);
                                    ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Full Width Content -->
                    <div class="tabs-section">
                        <div class="tab-navigation">
                            <div class="tab active" data-tab="details">Item Details</div>
                            <?php if (!empty($videoId)): ?>
                            <div class="tab" data-tab="preview">Video</div>
                            <?php endif; ?>
                             <div class="tab" data-tab="reviews">Reviews</div>
                            <div class="tab" data-tab="terms">Terms</div>

                            <div class="tab" data-tab="support">Support</div>
                        </div>
                        
                        <div class="tab-content">
                            <!-- Details Tab -->
                            <div class="tab-pane active" id="details-tab">
                                <div class="action-row">
                                    <?php if (!$userHasPurchased): ?>
                                    <button class="favorites-button" id="addToWishlistBtn" data-product-id="<?php echo $product['id']; ?>">
                                        <i class="fas fa-heart"></i> Add To Favorites
                                    </button>
                                    <?php endif; ?>
                                    <div class="share-section">
                                        <span class="share-label">Share:</span>
                                        <div class="share-icons">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank" class="share-icon"><i class="fab fa-facebook-f"></i></a>
                                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($product['product_name']); ?>" target="_blank" class="share-icon"><i class="fab fa-twitter"></i></a>
                                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank" class="share-icon"><i class="fab fa-linkedin-in"></i></a>
                                            <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&media=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . '/panels/admin/project/' . $product['featured_image']); ?>&description=<?php echo urlencode($product['product_name']); ?>" target="_blank" class="share-icon"><i class="fab fa-pinterest-p"></i></a>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if (!empty($product['description'])): ?>
                                    <div class="description">
                                        <?php echo $product['description']; ?>
                                    </div>
                                <?php else: ?>
                                    <ul class="feature-list">
                                        <li>Compatible with all modern design software versions</li>
                                        <li>Fully editable source files included</li>
                                        <li>All layers properly organized and labeled</li>
                                        <li>High-resolution assets (300 DPI)</li>
                                        <li>Professional design elements</li>
                                        <li>Modern and clean aesthetic</li>
                                    </ul>
                                    
                                    <div class="divider"></div>
                                    
                                    <p style="margin: 20px 0;">This template allows you to quickly customize and create your own professional designs without starting from scratch.</p>
                                    
                                    <p>All the necessary files are included in the download package, ready for your next project.</p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Preview Tab -->
                            <?php if (!empty($videoId)): ?>
                            <div class="tab-pane" id="preview-tab">
                                <div class="youtube-container">
                                    <iframe 
                                        src="https://www.youtube.com/embed/<?php echo htmlspecialchars($videoId); ?>" 
                                        title="<?php echo htmlspecialchars($product['product_name']); ?> Preview"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Terms Tab -->
                            <div class="tab-pane" id="terms-tab">
                                <h3 class="terms-heading">Terms & Conditions</h3>
                                
                                <h4 class="terms-subheading">License Information</h4>
                                <p>By downloading this item, you agree to the following terms:</p>
                                
                                <ul class="feature-list">
                                    <li><strong>Regular License:</strong> Allows you to use the item in a single end product which end users are not charged for.</li>
                                    <li><strong>Extended License:</strong> Allows you to use the item in a single end product which end users can be charged for.</li>
                                    <li>You cannot redistribute or resell the item as-is.</li>
                                    <li>The author retains ownership of the item, but grants you the license rights.</li>
                                    <li>This license is non-exclusive, non-transferable, and cannot be sublicensed.</li>
                                </ul>
                                
                                <div class="divider"></div>
                                
                                <h4 class="terms-subheading">Usage Restrictions</h4>
                                <p>The following uses are expressly prohibited:</p>
                                
                                <ul class="feature-list">
                                    <li>Illegal or defamatory content creation</li>
                                    <li>Content that infringes upon trademarks or intellectual property rights</li>
                                    <li>Content that promotes discrimination or harmful activities</li>
                                    <li>Redistribution through stock media platforms</li>
                                    <li>Use in logo design or trademarks without modifications</li>
                                </ul>
                                
                                <div class="divider"></div>
                                
                                <p class="terms-footer">For any specific licensing questions, please contact our support team. These terms may be updated periodically, so please check back for changes.</p>
                            </div>
                            
                            <!-- Reviews Tab -->
                            <div class="tab-pane" id="reviews-tab">
                                <?php echo renderReviewsSection($ratings, $product); ?>
                            </div>
                            
                            <!-- Support Tab -->
                            <div class="tab-pane" id="support-tab">
                                <h3 class="support-heading">Support Information</h3>
                                <p class="support-intro">For any issues or questions about this item, please contact our support team:</p>
                                <ul class="feature-list">
                                    <li>Email: support@saigfx.in</li>
                                    <li>Response time: Within 24-48 hours</li>
                                    <li>Support includes: Technical questions, item usage help</li>
                                </ul>
                                
                                <div class="divider"></div>
                                
                                <h4 class="faq-heading">Frequently Asked Questions</h4>
                                <div class="faq-item">
                                    <strong class="faq-question">Q: Can I use this item for commercial purposes?</strong>
                                    <p class="faq-answer">A: Yes, all items come with a commercial license that allows you to use them in your projects.</p>
                                </div>
                                
                                <div class="faq-item">
                                    <strong class="faq-question">Q: What software do I need to edit these files?</strong>
                                    <p class="faq-answer">A: It depends on the file format. PSD files require Adobe Photoshop, AI files need Adobe Illustrator, etc.</p>
                                </div>
                                
                                <div class="faq-item">
                                    <strong class="faq-question">Q: Are the fonts included in the download?</strong>
                                    <p class="faq-answer">A: For copyright reasons, fonts may not be included. We provide links to the fonts used, many of which are free for commercial use.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Related Products -->
                    <?php if (!empty($product['related_products'])): ?>
                    <div class="related-products">
                        <h2 class="section-heading">Related Products</h2>
                        <div class="related-grid">
                            <?php foreach ($product['related_products'] as $related): ?>
                                <a href="item.php?slug=<?php echo urlencode($related['slug']); ?>" class="related-item">
                                    <div class="related-image-wrapper">
                                        <img src="./panels/admin/project/<?php echo htmlspecialchars($related['featured_image']); ?>" 
                                             alt="<?php echo htmlspecialchars($related['product_name']); ?>"
                                             class="related-image">
                                    </div>
                                    <div class="related-content">
                                        <h3 class="related-title"><?php echo htmlspecialchars($related['product_name']); ?></h3>
                                        <?php if ($related['product_price'] > 0): ?>
                                            <?php if (!empty($related['discounted_price'])): ?>
                                                <div class="related-price">₹<?php echo number_format($related['discounted_price'], 2); ?></div>
                                            <?php else: ?>
                                                <div class="related-price">₹<?php echo number_format($related['product_price'], 2); ?></div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <div class="related-price">Free</div>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Subcategory Showcase -->
                    <?php if (!empty($product['subcategories'])): ?>
                    <div class="subcategory-showcase">
                        <h2 class="section-heading">Browse more</h2>
                        <div class="subcategory-slider-container">
                            <div class="subcategory-slider">
                                <?php 
                                $productSubcategoryIds = !empty($product['subcategory_id']) ? 
                                    explode(',', $product['subcategory_id']) : [];
                                    
                                foreach ($product['subcategories'] as $subcat): 
                                    $isActive = in_array($subcat['id'], $productSubcategoryIds);
                                ?>
                                    <a href="allproducts.php?category=<?php echo urlencode($product['category_id']); ?>&subcategory=<?php echo urlencode($subcat['id']); ?>" 
                                       class="subcategory-item <?php echo $isActive ? 'active-subcategory' : ''; ?>">
                                        <div class="subcategory-card">
                                            <div class="subcategory-icon">
                                                <?php if ($isActive): ?>
                                                    <i class="fas fa-check-circle"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-folder"></i>
                                                <?php endif; ?>
                                            </div>
                                            <h3 class="subcategory-title"><?php echo htmlspecialchars($subcat['name']); ?></h3>
                                            <?php if ($isActive): ?>
                                                <span class="subcategory-label current">Current</span>
                                            <?php else: ?>
                                                <span class="subcategory-label">Browse</span>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Navigation arrows -->
                            <div class="subcategory-nav">
                                <button class="subcategory-nav-btn prev">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="subcategory-nav-btn next">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- footer start -->
        <?php include_once "includes/footer.php"; ?>
        <!-- footer end -->
    </div>
    
    <!-- Loading overlay for async actions -->
    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>
    
    <script src="assets/js/product-view.js"></script>
    <script src="js/reviews.js"></script>
    <script src="js/item.js"></script>
    
    <!-- footer-copyright start -->
    <?php include_once "includes/footer-copyright.php"; ?>
    <!-- footer-copyright end -->
    
    <script>
// Initialize any global variables needed by other scripts
document.addEventListener('DOMContentLoaded', function() {
    console.log("Item page loaded successfully");
});
</script>
</body>
</html>
