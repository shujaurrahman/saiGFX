
<section class="Trending-product section-ptb">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="section-title text-center mb-4">
                    <span class="sub-title">From Your Network</span>
                    <h2>People You Follow</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            if (isset($_SESSION['id'])) {
                $Obj = new logics;
                $user_id = $_SESSION['id'];
                
                // Get projects from people the user follows
                $products = $Obj->getFollowedUserProjects($user_id);

                if (!empty($products['status']) && $products['status'] == 1):
                    // Show only first 3 products
                    $display_count = min(3, $products['count']);
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
                                    <i class="feather-users text-primary" style="font-size: 4rem;"></i>
                                </div>
                                <h5 class="mb-3">No Projects From Your Network</h5>
                                <p class="mb-0 text-muted">Follow more creators to see their projects here</p>
                            </div>
                        </div>
                    </div>
                <?php 
                endif;
            }
            ?>
        </div>

        <?php if (isset($_SESSION['id']) && !empty($products['status']) && $products['status'] == 1): ?>
            <div class="row">
                <div class="col-12 text-center mt-4">
                    <a href="allproducts.php?filter=followed" class="btn btn-primary">
                        View All Projects From Your Network <i class="feather-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>