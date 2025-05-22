<section class="Trending-product section-ptb">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="section-title text-center mb-4">
                    <span class="sub-title">Most Popular</span>
                    <h2>Top Trending PSD</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            $Obj = new logics;
            $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
            // Pass user_id to exclude their products
            $products = $Obj->getProducts($user_id);

            // Sort products by views in descending order
            $views = array_column($products['views'] ?? [], null);
            if (!empty($views)) {
                array_multisort($views, SORT_DESC, 
                    $products['id'], 
                    $products['uploader_id'],
                    $products['product_name'],
                    $products['featured_image'],
                    $products['short_description'],
                    $products['category_name'],
                    $products['product_price'],
                    $products['discounted_price'],
                    $products['project_files_zip'],
                    $products['views'],
                    $products['downloads'],
                    $products['verification_status'],
                    $products['slug']
                );
            }

            // Show only top 3 products
            $display_count = min(3, $products['count']);

            if (!empty($products['status']) && $products['status'] == 1):
                for ($i = 0; $i < $display_count; $i++):
                    if ($products['verification_status'][$i] === 'approved'):
            ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="item.php?slug=<?php echo htmlspecialchars($products['slug'][$i]); ?>" class="card-link">
                        <div class="card h-100">
                            <div class="position-relative">
                                <img src="./panels/admin/project/<?php echo htmlspecialchars($products['featured_image'][$i]); ?>"
                                     class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($products['product_name'][$i]); ?>">
                                <div class="project-meta position-absolute bottom-0 end-0 m-2 p-2 bg-dark bg-opacity-75 rounded text-white">
                                    <span class="me-3"><i class="feather-eye"></i> <?php echo number_format($products['views'][$i]); ?></span>
                                    <span><i class="feather-download"></i> <?php 
                                                                    $totalPurchases = $Obj->getTotalPurchases($products['id'][$i]);
                                    echo number_format($totalPurchases); ?></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="category-badge">
                                        <i class="feather-folder"></i><?php echo htmlspecialchars($products['category_name'][$i]); ?>
                                    </span>
                                </div>
                                <h5 class="card-title"><?php echo htmlspecialchars($products['product_name'][$i]); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($products['short_description'][$i]); ?></p>
                                <div class="">
                                    <div class="price-tag">
                                        <?php if ($products['product_price'][$i] > 0): ?>
                                            <?php if (!empty($products['discounted_price'][$i])): ?>
                                                <span class="new-price">₹<?php echo number_format($products['discounted_price'][$i], 2); ?></span>
                                                <span class="old-price">₹<?php echo number_format($products['product_price'][$i], 2); ?></span>
                                            <?php else: ?>
                                                <span class="new-price">₹<?php echo number_format($products['product_price'][$i], 2); ?></span>
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
            else:
            ?>
                <div class="col-12">
                    <div class="">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <i class="feather-package text-primary" style="font-size: 4rem;"></i>
                            </div>
                            <h5 class="mb-3">No Trending Projects Found</h5>
                            <p class="mb-0 text-muted">Check back later for new projects</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Add this after the row with products -->
        <div class="row">
            <div class="col-12 text-center mt-4">
                <a href="allproducts.php" class="btn btn-primary">
                    View All  <i class="feather-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.file-formats {
    color: #64748b;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    gap: 8px;
}

.file-formats span {
    background: #f8fafc;
    padding: 4px 10px;
    border-radius: 6px;
    font-family: monospace;
}

/* Card Container Styles */
.card-link {
    text-decoration: none;
    color: inherit;
    display: block;
    margin-bottom: 30px;
}

.card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.card-link:hover .card {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
}

/* Image Container Styles */
.position-relative {
    border-radius: 12px 12px 0 0;
    overflow: hidden;
    aspect-ratio: 16/10;
}

.card-img-top {
    height: 100%;
    width: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.card-link:hover .card-img-top {
    transform: scale(1.08);
}

/* Project Meta Styles */
.project-meta {
    z-index: 1;
    background: rgba(0, 0, 0, 0.85) !important;
    backdrop-filter: blur(4px);
    border-radius: 8px;
    padding: 8px 16px !important;
}

.project-meta span {
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.project-meta i {
    font-size: 1rem;
    opacity: 0.9;
}

/* Category Badge Styles */
.category-badge {
    display: inline-flex;
    align-items: center;
    background: #f0f5ff;
    color: #2563eb;
    font-size: 0.8rem;
    font-weight: 500;
    padding: 6px 14px;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.category-badge i {
    margin-right: 6px;
    font-size: 0.9rem;
}

.card-link:hover .category-badge {
    /* background: #fcba05; */
    color: white;
}

/* Card Content Styles */
.card-body {
    padding: 1.5rem;
}

.card-title {
    color: #111827;
    font-size: 1.15rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.card-text {
    color: #6b7280;
    font-size: 0.9rem;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Card Footer Styles */
.card-footer {
    background: none;
    border-top: 1px solid #f1f5f9;
    padding: 1rem 1.5rem;
    margin-top: auto;
}

.price-tag {
    display: flex;
    align-items: baseline;
    gap: 8px;
}

.new-price {
    color: #111827;
    font-size: 1.25rem;
    font-weight: 700;
}

.old-price {
    color: #94a3b8;
    text-decoration: line-through;
    font-size: 0.9rem;
}

.free-tag {
    color: #059669;
    font-size: 1.1rem;
    font-weight: 700;
    position: relative;
}

.free-tag::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 100%;
    height: 2px;
    background: currentColor;
    opacity: 0.3;
}

/* Section Title Styles */
.section-title {
    margin-bottom: 3rem !important;
}

.section-title .sub-title {
    color: #fcba05;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 1rem;
    display: block;
}

.section-title h2 {
    color: #111827;
    font-size: 2.5rem;
    font-weight: 700;
    position: relative;
}



.btn-primary {
    color: #fff;
    background-color: #fcba05;
    border-color: #fcba05;
}

.btn-primary:hover {
    color: #fcba05;
    background-color: #fff;
    border-color: #fff;
}
</style>