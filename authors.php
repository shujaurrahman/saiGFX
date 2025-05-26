<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require_once('logics.class.php');
$Obj = new logics();

// Get all users from admin table
$authors = $Obj->getUsers();

// Get additional stats for each author
$authorStats = array();
if ($authors['status'] == 1) {
    for ($i = 0; $i < $authors['count']; $i++) {
        $authorId = $authors['id'][$i];
        $authorStats[$authorId] = array(
            'followers' => $Obj->getFollowersCount($authorId),
            'following' => $Obj->getFollowingCount($authorId),
            'projects' => $Obj->getUserProjects($authorId),
            'rating' => $Obj->getUserAverageRating($authorId)
        );
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once "includes/links.php"; ?>

<head>
    <style>
        .authors-container {
            padding: 40px 0;
        }
        
        .authors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }
        
        .author-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        
        .author-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .author-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        
        .author-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 15px;
            overflow: hidden;
            border: 3px solid #fcba05;
        }
        
        .author-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .author-name {
            font-size: 1.2em;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }
        
        .author-role {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 15px;
        }
        
        .author-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            padding: 15px 20px;
            background: #f8f9fa;
        }
        
        .author-stat {
            text-align: center;
        }
        
        .stat-value {
            font-weight: 600;
            color: #333;
            font-size: 1.1em;
        }
        
        .stat-label {
            font-size: 0.8em;
            color: #666;
        }
        
        .author-actions {
            padding: 15px 20px;
            text-align: center;
        }
        
        .view-profile-btn {
            display: inline-block;
            padding: 8px 20px;
            background: #fcba05;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        
        .view-profile-btn:hover {
            background: #e5a800;
            color: #fff;
        }
        
        .rating-stars {
            color: #fcba05;
            font-size: 0.9em;
        }
        
        .section-heading {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .section-heading h2 {
            color: #333;
            font-size: 2em;
            margin-bottom: 10px;
        }
        
        .section-heading p {
            color: #666;
            font-size: 1.1em;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 20px;
        }
        
        .empty-state i {
            font-size: 3em;
            color: #ccc;
            margin-bottom: 20px;
        }
        
        .empty-state h3 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .empty-state p {
            color: #666;
        }
        
        .no-rating {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            color: #999;
            font-size: 0.9em;
        }
        
        .no-rating i {
            font-size: 1.2em;
            color: #ccc;
        }
        
        .no-rating span {
            font-size: 0.85em;
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
                            <ul class="breadcrumb-ul">
                                <li class="breadcrumb-li">
                                    <a class="breadcrumb-link" href="index.php">Home</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <span class="breadcrumb-text">Authors</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->

        <div class="authors-container">
            <div class="container">
                <div class="section-heading">
                    <h2>Our Creative Authors</h2>
                    <p>Discover talented creators and their amazing work</p>
                </div>
                
                <?php if ($authors['status'] == 1 && $authors['count'] > 0): ?>
                    <div class="authors-grid">
                        <?php for ($i = 0; $i < $authors['count']; $i++): 
                            $authorId = $authors['id'][$i];
                            $stats = $authorStats[$authorId];
                        ?>
                            <div class="author-card">
                                <div class="author-header">
                                    <div class="author-avatar">
                                        <?php 
                                        $profileImage = !empty($authors['profile_img'][$i]) 
                                            ? './panels/admin/uploads/profile/' . $authors['profile_img'][$i]
                                            : './panels/assets/img/avatars/1.png';
                                        ?>
                                        <img src="<?php echo htmlspecialchars($profileImage); ?>" 
                                             alt="<?php echo htmlspecialchars($authors['name'][$i]); ?>">
                                    </div>
                                    <h3 class="author-name">
                                        <?php echo htmlspecialchars($authors['name'][$i]); ?>
                                    </h3>
                                    <div class="author-role">
                                        <?php echo htmlspecialchars($authors['role'][$i]); ?>
                                    </div>
                                </div>
                                
                                <div class="author-stats">
                                    <div class="author-stat">
                                        <div class="stat-value">
                                            <?php echo isset($stats['projects']['count']) ? $stats['projects']['count'] : 0; ?>
                                        </div>
                                        <div class="stat-label">Projects</div>
                                    </div>
                                    <div class="author-stat">
                                        <div class="stat-value"><?php echo $stats['followers']; ?></div>
                                        <div class="stat-label">Followers</div>
                                    </div>
                                    <div class="author-stat">
                                        <div class="stat-value"><?php echo $stats['following']; ?></div>
                                        <div class="stat-label">Following</div>
                                    </div>
                                    <div class="author-stat">
                                        <div class="stat-value">
                                            <?php if ($stats['rating'] > 0): ?>
                                                <div class="rating-stars">
                                                <?php for ($j = 1; $j <= 5; $j++): ?>
                                                    <?php if ($j <= floor($stats['rating'])): ?>
                                                        <i class="fas fa-star"></i>
                                                    <?php elseif ($j - $stats['rating'] < 1): ?>
                                                        <i class="fas fa-star-half-alt"></i>
                                                    <?php else: ?>
                                                        <i class="far fa-star"></i>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                                </div>
                                                <?php echo number_format($stats['rating'], 1); ?>
                                            <?php else: ?>
                                                <div class="no-rating">
                                                    <i class="far fa-star"></i>
                                                    <span>No ratings yet</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($stats['rating'] > 0): ?>
                                            <div class="stat-label">Rating</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="author-actions">
                                    <a href="userProfile.php?id=<?php echo $authorId; ?>" class="view-profile-btn">
                                        View Profile
                                    </a>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <h3>No Authors Found</h3>
                        <p>There are no authors available at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <!-- main end -->
    
    <!-- footer start -->
    <?php include_once "includes/footer.php"; ?>
    <!-- footer end -->
    
    <!-- footer-copyright start -->
    <?php include_once "includes/footer-copyright.php"; ?>
    <!-- footer-copyright end -->
    
    <!-- Scripts -->
    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html> 