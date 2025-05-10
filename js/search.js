document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    const searchModal = document.getElementById('searchmodal');
    const clearButton = document.querySelector('.search-clear');
    let searchTimeout;
    let allProducts = [];
    let isLoading = false;
    let fetchAttempts = 0;
    const MAX_ATTEMPTS = 3;
    const DEBOUNCE_DELAY = 300;

    // Fetch all products when modal opens
    searchModal.addEventListener('show.bs.modal', function() {
        if (allProducts.length === 0 && !isLoading) {
            fetchAllProducts();
        }
        searchInput.value = '';
        searchResults.innerHTML = '';
    });

    // Focus input when modal opens
    searchModal.addEventListener('shown.bs.modal', function() {
        searchInput.focus();
    });

    // Clear search
    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        searchResults.innerHTML = '';
        searchInput.focus();
    });

    // Handle keyboard navigation
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            searchModal.querySelector('.btn-close').click();
        }
    });

    // Live search handler with debouncing
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim().toLowerCase();
        
        if (query.length >= 2) {
            showLoadingState();
            
            searchTimeout = setTimeout(() => {
                if (allProducts.length > 0) {
                    const filtered = filterProducts(query);
                    displayResults(filtered);
                } else if (!isLoading) {
                    fetchAllProducts(query);
                }
            }, DEBOUNCE_DELAY);
        } else if (query.length === 0) {
            searchResults.innerHTML = '';
        } else {
            showMinLengthMessage();
        }
    });

    // Fetch all products
    function fetchAllProducts(initialQuery = null) {
        if (isLoading || fetchAttempts >= MAX_ATTEMPTS) return;
        
        isLoading = true;
        fetchAttempts++;
        showLoadingState();
        
        fetch('api/get-products.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                isLoading = false;
                
                if (data && data.status === 1) {
                    allProducts = [];
                    // Convert the array format to object format
                    for (let i = 0; i < data.count; i++) {
                        allProducts.push({
                            id: data.id[i],
                            product_name: data.product_name[i],
                            category_name: data.category_name[i],
                            featured_image: data.featured_image[i],
                            short_description: data.short_description[i],
                            product_price: data.product_price[i],
                            discounted_price: data.discounted_price[i],
                            slug: data.slug[i]
                        });
                    }
                    
                    if (initialQuery) {
                        const filtered = filterProducts(initialQuery);
                        displayResults(filtered);
                    } else {
                        searchResults.innerHTML = '';
                    }
                } else {
                    throw new Error('Invalid data format received');
                }
            })
            .catch(error => {
                isLoading = false;
                console.error('Error fetching products:', error);
                showErrorState(error);
            });
    }

    // Filter products based on search query
    function filterProducts(query) {
        if (!allProducts || allProducts.length === 0) {
            return [];
        }
        
        const searchTerms = query.toLowerCase().split(' ').filter(term => term.length > 0);
        
        return allProducts.filter(product => {
            const productName = (product.product_name || '').toLowerCase();
            const description = (product.short_description || '').toLowerCase();
            const category = (product.category_name || '').toLowerCase();
            
            return searchTerms.every(term => 
                productName.includes(term) || 
                description.includes(term) || 
                category.includes(term)
            );
        });
    }

    // Display search results
    function displayResults(results) {
        if (results.length === 0) {
            searchResults.innerHTML = `
                <div class="col-12">
                    <div class="no-results">
                        <i class="feather-search"></i>
                        <h4>No products found</h4>
                        <p class="text-muted">Try different keywords or check your spelling</p>
                    </div>
                </div>`;
            return;
        }

        searchResults.innerHTML = results.map(product => `
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="single-product-wrap">
                    <div class="product-image">
                        <a href="item.php?slug=${encodeURIComponent(product.slug)}" class="pro-img">
                            <img src="./panels/admin/project/${encodeURIComponent(product.featured_image)}" 
                                 class="img-fluid" 
                                 alt="${product.product_name}"
                                 loading="lazy">
                        </a>
                    </div>
                    <div class="product-caption">
                        <div class="product-sub-title">
                            <span class="category-tag">${product.category_name || 'Uncategorized'}</span>
                        </div>
                        <div class="product-title">
                            <h6>
                                <a href="item.php?slug=${encodeURIComponent(product.slug)}">
                                    ${product.product_name}
                                </a>
                            </h6>
                        </div>
                        <div class="pro-price-box">
                            ${product.discounted_price ? 
                                `<span class="old-price">₹${product.product_price}</span>
                                 <span class="new-price">₹${product.discounted_price}</span>` :
                                `<span class="new-price">₹${product.product_price}</span>`
                            }
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // Show loading state
    function showLoadingState() {
        searchResults.innerHTML = `
            <div class="col-12">
                <div class="loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>`;
    }

    // Show error state
    function showErrorState(error) {
        searchResults.innerHTML = `
            <div class="col-12">
                <div class="error-state">
                    <i class="feather-alert-circle"></i>
                    <h5>Error loading products</h5>
                    <p>${error.message}</p>
                    <button class="btn btn-outline-danger mt-2" onclick="location.reload()">Retry</button>
                </div>
            </div>`;
    }

    // Show minimum length message
    function showMinLengthMessage() {
        searchResults.innerHTML = `
            <div class="col-12">
                <div class="no-results">
                    <i class="feather-info"></i>
                    <h4>Enter at least 2 characters</h4>
                    <p class="text-muted">Start typing to search products</p>
                </div>
            </div>`;
    }
});