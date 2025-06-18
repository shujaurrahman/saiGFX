<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('logics.class.php');

$Obj = new logics();

// Get user ID from URL parameter
$profile_user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$profile_user_id) {
    header('Location: index.php');
    exit();
}

// Get user profile data
$user = $Obj->getUserById($profile_user_id);
if (!$user || $user['status'] !== 1) {
    header('Location: index.php');
    exit();
}

// Get follow status if user is logged in
$isFollowing = false;
if (isset($_SESSION['id'])) {
    $isFollowing = $Obj->isFollowing($_SESSION['id'], $profile_user_id);
}

// Get user statistics
$followerCount = $Obj->getFollowersCount($profile_user_id);
$followingCount = $Obj->getFollowingCount($profile_user_id);

// Get user's projects/items
$userProjects = $Obj->getUserProjects($profile_user_id);

// Get all reviews for this user's products
$userReviews = $Obj->getUserProductReviews($profile_user_id);
$averageRating = $Obj->getUserAverageRating($profile_user_id);

// Add this after fetching the user data
$aboutInfo = $Obj->getUserAbout($profile_user_id);
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once "includes/links.php"; ?>

<head>
<link rel="stylesheet" href="css/userprofile.css">
<style>
.user-name-area {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.user-name-area h1 {
    margin: 0;
}

.authors-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #6b7280;
    font-size: 0.9rem;
    text-decoration: none;
    padding: 4px 12px;
    border-radius: 20px;
    background: #f3f4f6;
    transition: all 0.2s ease;
}

.authors-link:hover {
    color: #fcba05;
    background: #f8f9fa;
}

.authors-link i {
    font-size: 0.9em;
}

.verified-badge {
    color: #fcba05;
    font-size: 1.2em;
}
</style>
</head>

<body>
    <!-- notification-bar start -->
    <?php include_once "includes/banner.php"; ?>
    <!-- notification-bar end -->
    
    <!-- header start -->
    <?php include_once "includes/header.php"; ?>
    <!-- header end -->
    
    <!-- main start -->
    <main id="main-content">
        <!-- breadcrumb start -->
        <section class="breadcrumb-area">
            <div class="container">
                <div class="col">
                    <div class="row">
                        <div class="breadcrumb-index">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-ul">
                                <li class="breadcrumb-li">
                                    <a class="breadcrumb-link" href="index.php">Home</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <a class="breadcrumb-link" href="authors.php">Authors</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <span class="breadcrumb-text"><?php echo htmlspecialchars($user['name']); ?></span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->

        <div class="user-profile-container">
            <!-- User Profile Header -->
            <div class="user-profile-header">
                <div class="profile-banner"></div>
                <div class="profile-info">
                    <div class="profile-avatar">
                        <?php 
                        $profileImage = !empty($user['profile_img']) 
                            ? './panels/admin/uploads/profile/' . $user['profile_img']
                            : './panels/assets/img/avatars/1.png';
                        ?>
                        <img src="<?php echo htmlspecialchars($profileImage); ?>" 
                             alt="<?php echo htmlspecialchars($user['name']); ?>"
                             class="rounded-circle"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <div class="profile-details">
                        <div class="user-name-area">
                            <h1><?php echo htmlspecialchars($user['name']); ?></h1>
                            <?php if (isset($user['is_verified']) && $user['is_verified']): ?>
                                <span class="verified-badge"><i class="fas fa-check-circle"></i></span>
                            <?php endif; ?>
                            <a href="authors.php" class="authors-link">
                                <i class="fas fa-users"></i>
                                <span>Browse Authors</span>
                            </a>
                        </div>
                        <div class="username">@<?php echo htmlspecialchars($user['username'] ?? $user['name']); ?></div>
                        
                        <div class="user-stats">
                            <div class="stat-item">
                                <div class="stat-value"><?php echo isset($userProjects['count']) ? $userProjects['count'] : 0; ?></div>
                                <div class="stat-label">Projects</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value"><?php echo $followerCount; ?></div>
                                <div class="stat-label">Followers</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value"><?php echo $followingCount; ?></div>
                                <div class="stat-label">Following</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">
                                    <?php if ($averageRating > 0): ?>
                                        <div class="rating-stars">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= floor($averageRating)): ?>
                                                <i class="fas fa-star"></i>
                                            <?php elseif ($i - $averageRating < 1): ?>
                                                <i class="fas fa-star-half-alt"></i>
                                            <?php else: ?>
                                                <i class="far fa-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        </div>
                                        <?php echo number_format($averageRating, 1); ?>
                                    <?php else: ?>
                                        <!-- No ratings -->
                                    <?php endif; ?>
                                </div>
                                <!-- <div class="stat-label">Rating</div> -->
                            </div>
                        </div>
                        
                        <div class="user-bio">
                            <?php echo htmlspecialchars($user['bio'] ?? ''); ?>
                        </div>
                        
                        <div class="user-meta">
                            <?php if (!empty($user['location'])): ?>
                            <div class="meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo htmlspecialchars($user['location']); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($user['website'])): ?>
                            <div class="meta-item">
                                <i class="fas fa-globe"></i>
                                <span><?php echo htmlspecialchars($user['website']); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Member since <?php echo date('F Y', strtotime($user['created_at'])); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="profile-actions">
                        <?php if (isset($_SESSION['id']) && $_SESSION['id'] != $profile_user_id): ?>
                            <button class="follow-btn" data-user-id="<?php echo $profile_user_id; ?>" 
                                    data-following="<?php echo $isFollowing ? 'true' : 'false'; ?>">
                                <i class="fas <?php echo $isFollowing ? 'fa-user-minus' : 'fa-user-plus'; ?>"></i>
                                <?php echo $isFollowing ? 'Unfollow' : 'Follow'; ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Profile Tabs -->
            <div class="profile-tabs">
                <div class="container">
                    <div class="tabs-nav">
                        <div class="tab-item active" data-tab="items">
                            <span class="tab-label">Items</span>
                            <span class="tab-count"><?php echo isset($userProjects['count']) ? $userProjects['count'] : 0; ?></span>
                        </div>
                        <div class="tab-item" data-tab="reviews">
                            <span class="tab-label">Reviews</span>
                            <span class="tab-count"><?php echo count($userReviews); ?></span>
                        </div>
                        <div class="tab-item" data-tab="about">
                            <span class="tab-label">About</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tab Content -->
            <div class="container">
                <div class="tab-content active" id="items-tab">
                    <div class="section-heading">
                        <span>All Items (<?php echo isset($userProjects['count']) ? $userProjects['count'] : 0; ?>)</span>
                    </div>
                    
                    <div class="special-product grid-3">
                        <?php if (isset($userProjects['status']) && $userProjects['status'] == 1 && !empty($userProjects['data'])): ?>
                            <div class="collection-category">
                                <div class="row">
                                    <div class="col">
                                        <div class="collection-wrap">
                                            <ul class="product-view-ul">
                                                <?php foreach ($userProjects['data'] as $project): ?>
                                                    <li class="pro-item-li">
                                                        <div class="single-product-wrap">
                                                            <div class="product-image banner-hover">
                                                                <?php if (isset($project['discount_percentage']) && $project['discount_percentage'] > 0): ?>
                                                                    <span class="sale-tag">-<?php echo $project['discount_percentage']; ?>%</span>
                                                                <?php endif; ?>
                                                                
                                                                <a href="item.php?slug=<?php echo htmlspecialchars($project['slug']); ?>">
                                                                    <img src="./panels/admin/project/<?php echo htmlspecialchars($project['featured_image']); ?>" 
                                                                         class="img-product img1 mobile-img1" 
                                                                         alt="<?php echo htmlspecialchars($project['product_name']); ?>">
                                                                </a>
                                                            </div>
                                                            <div class="product-caption">
                                                                <div class="product-content">
                                                                    <div class="product-title">
                                                                        <h6>
                                                                            <a href="item.php?slug=<?php echo htmlspecialchars($project['slug']); ?>">
                                                                                <?php echo htmlspecialchars($project['product_name']); ?>
                                                                            </a>
                                                                        </h6>
                                                                    </div>
                                                                    <div class="product-price">
                                                                        <span class="new-price">₹<?php echo number_format($project['discounted_price'], 2); ?></span>
                                                                        <?php if (isset($project['discount_percentage']) && $project['discount_percentage'] > 0): ?>
                                                                            <span class="old-price">₹<?php echo number_format($project['product_price'], 2); ?></span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <h3>No items yet</h3>
                                <p>This user hasn't uploaded any items yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="tab-content" id="reviews-tab">
                    <div class="section-heading">
                        <span>Reviews (<?php echo count($userReviews); ?>)</span>
                    </div>
                    
                    <?php if (!empty($userReviews)): ?>
                        <!-- Reviews rating summary -->
                        <div class="reviews-summary">
                            <div class="overall-rating">
                                <div class="rating-number"><?php echo number_format($averageRating, 1); ?></div>
                                <div class="rating-stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= floor($averageRating)): ?>
                                            <i class="fas fa-star"></i>
                                        <?php elseif ($i - $averageRating < 1): ?>
                                            <i class="fas fa-star-half-alt"></i>
                                        <?php else: ?>
                                            <i class="far fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <div class="total-reviews"><?php echo count($userReviews); ?> reviews</div>
                            </div>
                        </div>
                        
                        <!-- Reviews list -->
                        <div class="reviews-list">
                            <?php foreach ($userReviews as $review): ?>
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <div class="reviewer-avatar">
                                                <?php if (!empty($review['reviewer_img'])): ?>
                                                    <img src="./panels/admin/uploads/profile/<?php echo htmlspecialchars($review['reviewer_img']); ?>" alt="<?php echo htmlspecialchars($review['reviewer_name']); ?>">
                                                <?php else: ?>
                                                    <i class="fas fa-user-circle"></i>
                                                <?php endif; ?>
                                            </div>
                                            <div class="reviewer-details">
                                                <h5 class="reviewer-name"><?php echo htmlspecialchars($review['reviewer_name']); ?></h5>
                                                <div class="review-date"><?php echo date('M d, Y', strtotime($review['created_at'])); ?></div>
                                            </div>
                                        </div>
                                        <div class="review-product">
                                            <div class="product-link">
                                                <a href="item.php?slug=<?php echo htmlspecialchars($review['product_slug']); ?>">
                                                    <?php echo htmlspecialchars($review['product_name']); ?>
                                                </a>
                                            </div>
                                            <div class="product-rating">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="<?php echo ($i <= $review['rating']) ? 'fas' : 'far'; ?> fa-star"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-content">
                                        <h5 class="review-title"><?php echo htmlspecialchars($review['review_title']); ?></h5>
                                        <p class="review-text"><?php echo nl2br(htmlspecialchars($review['review_content'])); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-star"></i>
                            <h3>No reviews yet</h3>
                            <p>This user hasn't received any reviews on their products yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="tab-content" id="about-tab">
                    <div class="section-heading">
                        <span>About <?php echo htmlspecialchars($user['name']); ?></span>
                    </div>
                    
                    <?php if (!empty($aboutInfo) && (!empty($aboutInfo['biography']) || !empty($aboutInfo['skills']) || !empty($aboutInfo['experience']))): ?>
                        <!-- Biography Section -->
                        <div class="about-section">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="section-title"><i class="fas fa-user-circle me-2"></i>Biography</h5>
                                    <div class="biography-content">
                                        <?php if (!empty($aboutInfo['biography'])): ?>
                                            <?php echo $aboutInfo['biography']; ?> <!-- Remove htmlspecialchars to render HTML -->
                                        <?php else: ?>
                                            <p class="text-muted">No biography available.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Skills & Experience in 2 columns -->
                            <div class="row">
                                <!-- Left column -->
                                <div class="col-md-6">
                                    <!-- Skills Section -->
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="section-title"><i class="fas fa-tools text-primary me-2"></i>Skills</h5>
                                            <?php if (!empty($aboutInfo['skills'])): ?>
                                                <div class="skills-container">
                                                    <?php foreach (explode(',', $aboutInfo['skills']) as $skill): ?>
                                                        <span class="skill-tag"><?php echo htmlspecialchars(trim($skill)); ?></span>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <p class="text-muted">No skills listed</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Education Section -->
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="section-title"><i class="fas fa-graduation-cap text-primary me-2"></i>Education</h5>
                                            <?php if (!empty($aboutInfo['education'])): ?>
                                                <div class="education-content">
                                                    <?php echo nl2br(htmlspecialchars($aboutInfo['education'])); ?>
                                                </div>
                                            <?php else: ?>
                                                <p class="text-muted">No education information available</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Languages Section -->
                                    <?php if (!empty($aboutInfo['languages'])): ?>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="section-title"><i class="fas fa-language text-primary me-2"></i>Languages</h5>
                                            <div class="languages-container">
                                                <?php foreach (explode(',', $aboutInfo['languages']) as $language): ?>
                                                    <span class="language-tag"><?php echo htmlspecialchars(trim($language)); ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Right column -->
                                <div class="col-md-6">
                                    <!-- Experience Section -->
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="section-title"><i class="fas fa-briefcase text-primary me-2"></i>Work Experience</h5>
                                            <?php if (!empty($aboutInfo['experience'])): ?>
                                                <div class="experience-content">
                                                    <?php echo nl2br(htmlspecialchars($aboutInfo['experience'])); ?>
                                                </div>
                                            <?php else: ?>
                                                <p class="text-muted">No work experience listed</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Location Section -->
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="section-title"><i class="fas fa-map-marked-alt text-primary me-2"></i>Location</h5>
                                            <?php if (!empty($aboutInfo['location'])): ?>
                                                <div class="location-content">
                                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                                    <?php echo htmlspecialchars($aboutInfo['location']); ?>
                                                </div>
                                            <?php else: ?>
                                                <p class="text-muted">No location information available</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Contact Information -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="section-title"><i class="fas fa-address-card text-primary me-2"></i>Contact Information</h5>
                                    <div class="contact-grid">
                                        <?php if (!empty($aboutInfo['email'])): ?>
                                            <div class="contact-item">
                                                <i class="fas fa-envelope contact-icon"></i>
                                                <a href="mailto:<?php echo htmlspecialchars($aboutInfo['email']); ?>"><?php echo htmlspecialchars($aboutInfo['email']); ?></a>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($aboutInfo['website'])): ?>
                                            <div class="contact-item">
                                                <i class="fas fa-globe contact-icon"></i>
                                                <a href="<?php echo htmlspecialchars($aboutInfo['website']); ?>" target="_blank"><?php echo htmlspecialchars($aboutInfo['website']); ?></a>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($aboutInfo['phone'])): ?>
                                            <div class="contact-item">
                                                <i class="fas fa-phone-alt contact-icon"></i>
                                                <a href="tel:<?php echo htmlspecialchars($aboutInfo['phone']); ?>"><?php echo htmlspecialchars($aboutInfo['phone']); ?></a>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($aboutInfo['whatsapp'])): ?>
                                            <div class="contact-item">
                                                <i class="fab fa-whatsapp contact-icon whatsapp-icon"></i>
                                                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $aboutInfo['whatsapp']); ?>" target="_blank"><?php echo htmlspecialchars($aboutInfo['whatsapp']); ?></a>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($aboutInfo['telegram'])): ?>
                                            <div class="contact-item">
                                                <i class="fab fa-telegram-plane contact-icon telegram-icon"></i>
                                                <a href="<?php echo strpos($aboutInfo['telegram'], 'http') === 0 ? htmlspecialchars($aboutInfo['telegram']) : 'https://t.me/' . htmlspecialchars(ltrim($aboutInfo['telegram'], '@')); ?>" target="_blank"><?php echo htmlspecialchars($aboutInfo['telegram']); ?></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Social Media Links -->
                            <?php 
                            $hasSocialLinks = !empty($aboutInfo['facebook']) || 
                                              !empty($aboutInfo['twitter']) || 
                                              !empty($aboutInfo['instagram']) || 
                                              !empty($aboutInfo['linkedin']) || 
                                              !empty($aboutInfo['github']) || 
                                              !empty($aboutInfo['dribbble']) || 
                                              !empty($aboutInfo['behance']);
                                              
                            if ($hasSocialLinks): 
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="section-title"><i class="fas fa-share-alt text-primary me-2"></i>Connect with <?php echo htmlspecialchars($user['name']); ?></h5>
                                    <div class="social-links">
                                        <?php if (!empty($aboutInfo['facebook'])): ?>
                                            <a href="<?php echo htmlspecialchars($aboutInfo['facebook']); ?>" class="social-link facebook" target="_blank" title="Facebook">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($aboutInfo['twitter'])): ?>
                                            <a href="<?php echo htmlspecialchars($aboutInfo['twitter']); ?>" class="social-link twitter" target="_blank" title="Twitter">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($aboutInfo['instagram'])): ?>
                                            <a href="<?php echo htmlspecialchars($aboutInfo['instagram']); ?>" class="social-link instagram" target="_blank" title="Instagram">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($aboutInfo['linkedin'])): ?>
                                            <a href="<?php echo htmlspecialchars($aboutInfo['linkedin']); ?>" class="social-link linkedin" target="_blank" title="LinkedIn">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($aboutInfo['github'])): ?>
                                            <a href="<?php echo htmlspecialchars($aboutInfo['github']); ?>" class="social-link github" target="_blank" title="GitHub">
                                                <i class="fab fa-github"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($aboutInfo['dribbble'])): ?>
                                            <a href="<?php echo htmlspecialchars($aboutInfo['dribbble']); ?>" class="social-link dribbble" target="_blank" title="Dribbble">
                                                <i class="fab fa-dribbble"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($aboutInfo['behance'])): ?>
                                            <a href="<?php echo htmlspecialchars($aboutInfo['behance']); ?>" class="social-link behance" target="_blank" title="Behance">
                                                <i class="fab fa-behance"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <!-- Empty state for when no about information is available -->
                        <div class="empty-about-state">
                            <div class="empty-state">
                                <i class="fas fa-user-circle"></i>
                                <h3>No profile information available</h3>
                                <p><?php echo htmlspecialchars($user['name']); ?> hasn't added any detailed profile information yet.</p>
                                
                                <?php if (isset($_SESSION['id']) && $_SESSION['id'] == $profile_user_id): ?>
                                    <a href="./panels/admin/editAbout.php" class="btn btn-primary">
                                        <i class="fas fa-user-edit me-2"></i> Complete Your Profile
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <!-- main end -->
        <?php
    include_once "includes/footer.php"
        ?>
    <!-- footer start -->
    <?php include_once "includes/footer-copyright.php"; ?>
    <!-- footer end -->
    
    <!-- Scripts -->
    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    
    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabItems = document.querySelectorAll('.tab-item');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabItems.forEach(tab => tab.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    // Show corresponding content
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(`${tabId}-tab`).classList.add('active');
                });
            });
        });

        // Follow/Unfollow functionality
        $(document).ready(function() {
            $('.follow-btn').click(function() {
                const btn = $(this);
                const userId = btn.data('user-id');
                const isFollowing = btn.data('following') === 'true';
                
                // Show a loading indicator
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
                
                $.ajax({
                    url: 'toggle-follow.php',
                    type: 'POST',
                    data: JSON.stringify({ user_id: userId }),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        btn.prop('disabled', false);
                        
                        if (response.status === 1) {
                            // Success - reload the page to show updated state
                            location.reload();
                        } else {
                            // Show error message
                            alert(response.message || 'Something went wrong. Please try again.');
                            
                            // Reset button to original state
                            if (isFollowing) {
                                btn.html('<i class="fas fa-user-minus"></i> Unfollow');
                            } else {
                                btn.html('<i class="fas fa-user-plus"></i> Follow');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        btn.prop('disabled', false);
                        alert('Something went wrong. Please try again.');
                        
                        // Reset button to original state
                        if (isFollowing) {
                            btn.html('<i class="fas fa-user-minus"></i> Unfollow');
                        } else {
                            btn.html('<i class="fas fa-user-plus"></i> Follow');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>