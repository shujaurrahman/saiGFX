<?php
$Obj = new logics;
$categories = $Obj->getCategories();

// Get the logged-in user's ID
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if (!empty($categories['status']) && $categories['status'] == 1):
    for ($catIndex = 0; $catIndex < $categories['count']; $catIndex++):
        // Get products for this category, excluding user's own products
        $categoryProducts = $Obj->getProducts($user_id, $categories['id'][$catIndex]);
        $productCount = 0;
        
        // Only show category if it has products
        if (!empty($categoryProducts['status']) && $categoryProducts['status'] == 1):
            // Count products that belong to this category
            for ($i = 0; $i < $categoryProducts['count']; $i++):
                if ($categoryProducts['verification_status'][$i] === 'approved' && 
                    $categoryProducts['category_id'][$i] == $categories['id'][$catIndex]):
                    $productCount++;
                endif;
            endfor;
            
            // Only display category section if it has at least one product
            if ($productCount > 0):
?>
<section class="category-products section-ptb">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="section-title text-center mb-4">
                <span class="sub-title">Category</span>
                    <h2><?php echo htmlspecialchars($categories['name'][$catIndex]); ?></h2>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            $productCount = 0;
            for ($i = 0; $i < $categoryProducts['count'] && $productCount < 8; $i++):
                if ($categoryProducts['verification_status'][$i] === 'approved' && 
                    $categoryProducts['category_id'][$i] == $categories['id'][$catIndex]):
                    $productCount++;
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="item.php?slug=<?php echo htmlspecialchars($categoryProducts['slug'][$i]); ?>" class="card-link">
                        <div class="card h-100">
                            <div class="position-relative">
                                <img src="./panels/admin/project/<?php echo htmlspecialchars($categoryProducts['featured_image'][$i]); ?>"
                                     class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($categoryProducts['product_name'][$i]); ?>">
                                <div class="project-meta position-absolute bottom-0 end-0 m-2 p-2 bg-dark bg-opacity-75 rounded text-white">
                                    <span class="me-3"><i class="feather-eye"></i> <?php echo number_format($categoryProducts['views'][$i]); ?></span>
                                    <span><i class="feather-download"></i> <?php 
                                        $totalPurchases = $Obj->getTotalPurchases($categoryProducts['id'][$i]);
                                        echo number_format($totalPurchases); ?></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($categoryProducts['product_name'][$i]); ?></h5>
                                <!-- <p class="card-text"><?php echo htmlspecialchars($categoryProducts['short_description'][$i]); ?></p> -->
                                <div class="">
                                    <div class="price-tag">
                                        <?php if ($categoryProducts['product_price'][$i] > 0): ?>
                                            <?php if (!empty($categoryProducts['discounted_price'][$i])): ?>
                                                <span class="new-price">₹<?php echo number_format($categoryProducts['discounted_price'][$i], 2); ?></span>
                                                <span class="old-price">₹<?php echo number_format($categoryProducts['product_price'][$i], 2); ?></span>
                                            <?php else: ?>
                                                <span class="new-price">₹<?php echo number_format($categoryProducts['product_price'][$i], 2); ?></span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="free-tag">Free</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php 
                endif;
            endfor; 
            ?>
        </div>

        <!-- View All Button -->
        <div class="row">
            <div class="col-12 text-center mt-4">
                <a href="allproducts.php?category=<?php echo $categories['id'][$catIndex]; ?>" class="btn btn-primary">
                    View All <?php echo htmlspecialchars($categories['name'][$catIndex]); ?> <i class="feather-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.category-products {
    padding: 60px 0;
}

.category-products .card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.category-products .card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.category-products .card-link:hover .card {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
}

.category-products .position-relative {
    border-radius: 12px 12px 0 0;
    overflow: hidden;
    aspect-ratio: 16/10;
}

.category-products .card-img-top {
    height: 100%;
    width: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.category-products .card-link:hover .card-img-top {
    transform: scale(1.08);
}

.category-products .project-meta {
    z-index: 1;
    background: rgba(0, 0, 0, 0.85) !important;
    backdrop-filter: blur(4px);
    border-radius: 8px;
    padding: 8px 16px !important;
}

.category-products .project-meta span {
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.category-products .project-meta i {
    font-size: 1rem;
    opacity: 0.9;
}

.category-products .card-body {
    padding: 1.5rem;
}

.category-products .card-title {
    color: #111827;
    font-size: 1.15rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.category-products .card-text {
    color: #6b7280;
    font-size: 0.9rem;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.category-products .card-footer {
    background: none;
    border-top: 1px solid #f1f5f9;
    padding: 1rem 1.5rem;
    margin-top: auto;
}

.category-products .price-tag {
    display: flex;
    align-items: baseline;
    gap: 8px;
}

.category-products .new-price {
    color: #111827;
    font-size: 1.25rem;
    font-weight: 700;
}

.category-products .old-price {
    color: #94a3b8;
    text-decoration: line-through;
    font-size: 0.9rem;
}

.category-products .free-tag {
    color: #059669;
    font-size: 1.1rem;
    font-weight: 700;
    position: relative;
}

.category-products .free-tag::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 100%;
    height: 2px;
    background: currentColor;
    opacity: 0.3;
}

.category-products .section-title {
    margin-bottom: 3rem !important;
}

.category-products .section-title h2 {
    color: #111827;
    font-size: 2.5rem;
    font-weight: 700;
    position: relative;
}

.category-products .btn-primary {
    color: #fff;
    background-color: #fcba05;
    border-color: #fcba05;
}

.category-products .btn-primary:hover {
    color: #fcba05;
    background-color: #fff;
    border-color: #fcba05;
}
</style>
<?php
            endif;
        endif;
    endfor;
endif;
?> 