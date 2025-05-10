// Remove or comment out the changeImage function since we won't be using it anymore
/*
function changeImage(thumbnail, imgSrc) {
    const mainImage = document.getElementById('main-image');
    
    // Add fade-out effect
    mainImage.style.opacity = '0';
    
    // Change the image source after a short delay
    setTimeout(() => {
        mainImage.src = imgSrc;
        // Fade in the new image
        mainImage.style.opacity = '1';
    }, 200);
    
    // Update active state
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.classList.remove('active');
    });
    thumbnail.classList.add('active');
}
*/

// Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Update active tab
            tabs.forEach(t => {
                t.classList.remove('active');
            });
            tab.classList.add('active');
            
            // Show corresponding tab content
            const tabId = tab.getAttribute('data-tab');
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('active');
            });
            document.getElementById(tabId + '-tab').classList.add('active');
        });
    });
    
    // Utility functions that can be used by all handlers
    function showLoading() {
        const loadingOverlay = document.querySelector('.loading-overlay');
        if (loadingOverlay) loadingOverlay.classList.add('active');
    }
    
    function hideLoading() {
        const loadingOverlay = document.querySelector('.loading-overlay');
        if (loadingOverlay) loadingOverlay.classList.remove('active');
    }
    
    function showMessage(message, isError = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isError ? 'error' : 'success'}`;
        messageDiv.textContent = message;
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 3000);
    }
    
    // Add to favorites functionality - FIXED
    const addToWishlistBtn = document.getElementById('addToWishlistBtn');
    if (addToWishlistBtn) {
        addToWishlistBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log("Add to Wishlist clicked");
            
            const productId = this.getAttribute('data-product-id');
            showLoading();
            
            fetch('add-to-wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                
                if (data.status === 0) {
                    if (confirm('You need to be logged in to add items to wishlist. Go to login page?')) {
                        window.location.href = './panels/admin/login.php';
                    }
                } else {
                    showMessage(data.status === 1 ? 'Added to wishlist!' : 'Already in wishlist!');
                    this.innerHTML = '<i class="fas fa-heart" style="color: red;"></i> In Favorites';
                    this.disabled = true;
                    
                    // Add redirect to wishlist page after a short delay
                    setTimeout(() => {
                        window.location.href = './wishlist.php';
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hideLoading();
                showMessage('Something went wrong. Please try again', true);
            });
        });
    }
    
    // Buy Now functionality - FIXED
    const buyNowBtn = document.getElementById('buyNowBtn');
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log("Buy Now clicked");
            
            const productId = this.getAttribute('data-product-id');
            showLoading();
            
            fetch('add-to-cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                
                if (data.status === 0) {
                    if (confirm('You need to be logged in to buy items. Go to login page?')) {
                        window.location.href = './panels/admin/login.php';
                    }
                } else {
                    // Show success message
                    this.innerHTML = '<i class="fas fa-check"></i> Added to Cart';
                    showMessage('Item added to cart!');
                    
                    // Redirect to cart page after a short delay
                    setTimeout(() => {
                        window.location.href = './cart.php';
                    }, 1000);
                    
                    // Update cart count if available in the header
                    const cartCountElement = document.querySelector('.cart-count');
                    if (cartCountElement && data.cart_count) {
                        cartCountElement.textContent = data.cart_count;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hideLoading();
                showMessage('Something went wrong. Please try again', true);
            });
        });
    }
    
    // Follow/Unfollow functionality - FIXED
    const followButton = document.getElementById('followButton');
    if (followButton) {
        followButton.addEventListener('click', function(e) {
            e.preventDefault();
            console.log("Follow button clicked");
            
            const userId = this.getAttribute('data-user-id');
            showLoading();
            
            fetch('toggle-follow.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                
                if (data.status === 0) {
                    if (confirm('You need to be logged in to follow users. Go to login page?')) {
                        window.location.href = './panels/admin/login.php';
                    }
                } else {
                    if (data.action === 'followed') {
                        this.innerHTML = '<i class="fas fa-check"></i> Following';
                        showMessage('Now following this user!');
                    } else {
                        this.innerHTML = '<i class="fas fa-user-plus"></i> Follow';
                        showMessage('Unfollowed this user');
                    }
                    
                    // Reload the page after a short delay to update follow counts and status
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hideLoading();
                showMessage('Something went wrong. Please try again', true);
            });
        });
    }

    // Initialize subcategory slider
    const slider = document.querySelector('.subcategory-slider');
    if (slider) {
        // Get navigation buttons
        const prevBtn = document.querySelector('.subcategory-nav-btn.prev');
        const nextBtn = document.querySelector('.subcategory-nav-btn.next');
        
        // Add horizontal scroll with mouse wheel support
        slider.addEventListener('wheel', (e) => {
            e.preventDefault();
            slider.scrollLeft += e.deltaY;
        });
        
        // Touch/mouse drag scrolling variables
        let isDown = false;
        let startX;
        let scrollLeft;
        
        // Touch/mouse drag scrolling event listeners
        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.style.cursor = 'grabbing';
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
            e.preventDefault();
        });
        
        slider.addEventListener('touchstart', (e) => {
            isDown = true;
            startX = e.touches[0].pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        
        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.style.cursor = 'grab';
        });
        
        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.style.cursor = 'grab';
        });
        
        slider.addEventListener('touchend', () => {
            isDown = false;
        });
        
        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2; // Faster scroll speed
            slider.scrollLeft = scrollLeft - walk;
        });
        
        slider.addEventListener('touchmove', (e) => {
            if (!isDown) return;
            const x = e.touches[0].pageX - slider.offsetLeft;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
            e.preventDefault(); // Prevent page scrolling while dragging
        });
        
        // Set initial grab cursor
        slider.style.cursor = 'grab';
        
        // Configure navigation buttons if they exist
        if (prevBtn && nextBtn) {
            // Fixed scroll amount - width of one item plus gap
            const scrollAmount = 200;
            
            // Previous button click handler
            prevBtn.addEventListener('click', function() {
                slider.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            });
            
            // Next button click handler
            nextBtn.addEventListener('click', function() {
                slider.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });
            
            // Show/hide navigation buttons based on scroll position
            slider.addEventListener('scroll', () => {
                prevBtn.style.display = slider.scrollLeft > 0 ? 'flex' : 'none';
                nextBtn.style.display = 
                    slider.scrollLeft < (slider.scrollWidth - slider.clientWidth) ? 'flex' : 'none';
            });
            
            // Initial button visibility
            prevBtn.style.display = 'none';
            nextBtn.style.display = 
                slider.scrollWidth > slider.clientWidth ? 'flex' : 'none';
        }
        
        // Auto scroll to active subcategory if exists
        const activeSubcategory = slider.querySelector('.active-subcategory');
        if (activeSubcategory) {
            // Calculate scroll position to center the active item
            const centerPosition = activeSubcategory.offsetLeft - 
                                  (slider.clientWidth / 2) + 
                                  (activeSubcategory.offsetWidth / 2);
            
            // Apply smooth scroll after a short delay
            setTimeout(() => {
                slider.scrollTo({
                    left: centerPosition,
                    behavior: 'smooth'
                });
            }, 300);
        }
    }

    // Make the product rating clickable to navigate to reviews tab
    const productRating = document.querySelector('.product-rating');
    if (productRating) {
        productRating.addEventListener('click', function() {
            // Find the reviews tab and click it
            const reviewsTab = document.querySelector('.tab[data-tab="reviews"]');
            if (reviewsTab) {
                reviewsTab.click();
                
                // Smooth scroll to reviews section
                document.getElementById('reviews-tab').scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    }
});