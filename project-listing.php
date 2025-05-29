<?php
// Get filter parameter from URL
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Get products based on filter
$allProducts = [];
switch ($filter) {
    case 'followed':
        if (isset($_SESSION['id'])) {
            $allProducts = $Obj->getFollowedUserProjects($_SESSION['id']);
            $breadcrumbTitle = "Projects From People You Follow";
        }
        break;
        
    case 'trending':
        $allProducts = $Obj->getProducts();
        // Sort by views
        if (!empty($allProducts['views'])) {
            array_multisort($allProducts['views'], SORT_DESC, 
                $allProducts['id'],
                $allProducts['product_name'],
                $allProducts['featured_image'],
                $allProducts['uploader_id'],
                $allProducts['verification_status']
            );
        }
        $breadcrumbTitle = "Trending Projects";
        break;
        
    case 'recommended':
        $allProducts = $Obj->getProducts();
        // Filter recommended products
        if (!empty($allProducts['status']) && $allProducts['status'] == 1) {
            $recommended = [];
            for ($i = 0; $i < $allProducts['count']; $i++) {
                if ($allProducts['is_recommended'][$i] == 1) {
                    foreach ($allProducts as $key => $values) {
                        if (is_array($values)) {
                            $recommended[$key][] = $values[$i];
                        }
                    }
                }
            }
            $recommended['status'] = 1;
            $recommended['count'] = count($recommended['id'] ?? []);
            $allProducts = $recommended;
        }
        $breadcrumbTitle = "Recommended Projects";
        break;
        
    default:
        $allProducts = $Obj->getProducts();
        break;
}
?>

<!-- Update the card UI with more spacing and cleaner design -->