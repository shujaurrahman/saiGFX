document.addEventListener('DOMContentLoaded', function() {
    // Get references to review elements
    const reviewForm = document.getElementById('review-form');
    const reviewTitleInput = document.getElementById('review-title');
    const reviewContentInput = document.getElementById('review-content');
    const ratingStars = document.querySelectorAll('.rating-input i');
    const loadMoreButton = document.getElementById('load-more-reviews');
    const reviewsList = document.querySelector('.reviews-list');
    
    // Selected rating value
    let selectedRating = 0;
    
    // Initialize rating stars
    if (ratingStars.length > 0) {
        // Get initial rating from active stars
        selectedRating = document.querySelectorAll('.rating-input i.active').length;
        
        ratingStars.forEach(star => {
            // Star click handler
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                updateStars(rating);
                selectedRating = rating;
            });
            
            // Star hover effects
            star.addEventListener('mouseover', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                highlightStars(rating);
            });
            
            star.addEventListener('mouseout', function() {
                resetStars();
            });
        });
    }
    
    // Star rating helper functions
    function updateStars(rating) {
        ratingStars.forEach(star => {
            const starRating = parseInt(star.getAttribute('data-rating'));
            
            if (starRating <= rating) {
                star.classList.remove('far');
                star.classList.add('fas');
                star.classList.add('active');
            } else {
                star.classList.remove('fas');
                star.classList.add('far');
                star.classList.remove('active');
            }
        });
    }
    
    function highlightStars(rating) {
        ratingStars.forEach(star => {
            const starRating = parseInt(star.getAttribute('data-rating'));
            
            if (starRating <= rating) {
                star.classList.remove('far');
                star.classList.add('fas');
            } else {
                star.classList.remove('fas');
                star.classList.add('far');
            }
        });
    }
    
    function resetStars() {
        ratingStars.forEach(star => {
            const starRating = parseInt(star.getAttribute('data-rating'));
            
            if (star.classList.contains('active')) {
                star.classList.remove('far');
                star.classList.add('fas');
            } else {
                star.classList.remove('fas');
                star.classList.add('far');
            }
        });
    }
    
    // Review form submission
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate input
            if (selectedRating === 0) {
                showMessage('Please select a rating', true);
                return;
            }
            
            if (!reviewTitleInput.value.trim()) {
                showMessage('Please enter a review title', true);
                reviewTitleInput.focus();
                return;
            }
            
            if (!reviewContentInput.value.trim()) {
                showMessage('Please enter review content', true);
                reviewContentInput.focus();
                return;
            }
            
            // Prepare review data
            const productId = reviewForm.querySelector('input[name="product_id"]').value;
            const reviewData = {
                product_id: productId,
                rating: selectedRating,
                review_title: reviewTitleInput.value.trim(),
                review_content: reviewContentInput.value.trim()
            };
            
            // Show loading
            showLoading();
            
            // Submit review via AJAX
            fetch('add-review.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(reviewData)
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                
                if (data.status === 1) {
                    // Success
                    showMessage(data.message);
                    
                    // If we have a new review to display
                    if (data.review) {
                        // Check if we need to replace an existing review or add a new one
                        const existingReview = document.querySelector(`.review-item[data-review-id="${data.review.id}"]`);
                        
                        if (existingReview) {
                            // Replace existing review
                            existingReview.outerHTML = createReviewHTML(data.review);
                        } else {
                            // Add new review at the top
                            const reviewsList = document.querySelector('.reviews-list');
                            const noReviewsMsg = reviewsList.querySelector('.no-reviews');
                            
                            if (noReviewsMsg) {
                                // Remove the "no reviews" message
                                noReviewsMsg.remove();
                            }
                            
                            // Add the new review at the top
                            const reviewHTML = createReviewHTML(data.review);
                            reviewsList.insertAdjacentHTML('afterbegin', reviewHTML);
                            
                            // Update review count and average
                            updateReviewStats();
                        }
                    }
                    
                    // Reset the form
                    reviewForm.reset();
                    selectedRating = 0;
                    updateStars(0);
                    
                    // Update the button text to reflect you can edit the review now
                    document.querySelector('.submit-review-btn').textContent = 'Update Review';
                    document.querySelector('#review-form-container h4').textContent = 'Edit Your Review';
                    
                } else {
                    // Error
                    showMessage(data.message, true);
                }
            })
            .catch(error => {
                hideLoading();
                showMessage('Something went wrong. Please try again.', true);
            });
        });
    }
    
    // Load more reviews button
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const page = parseInt(this.getAttribute('data-page')) || 1;
            
            // Show loading
            showLoading();
            
            // Fetch more reviews
            fetch(`get-more-reviews.php?product_id=${productId}&page=${page}`)
            .then(response => response.json())
            .then(data => {
                hideLoading();
                
                if (data.status === 1 && data.reviews.length > 0) {
                    // Add reviews to the list
                    data.reviews.forEach(review => {
                        const reviewHTML = createReviewHTML(review);
                        reviewsList.insertAdjacentHTML('beforeend', reviewHTML);
                    });
                    
                    // Update the page counter for next load
                    this.setAttribute('data-page', page + 1);
                    
                    // Hide the button if no more reviews
                    if (data.reviews.length < 10) {
                        this.style.display = 'none';
                    }
                } else {
                    // No more reviews to load
                    this.style.display = 'none';
                }
            })
            .catch(error => {
                hideLoading();
                showMessage('Error loading more reviews', true);
            });
        });
    }
    
    // Helper function to create review HTML
    function createReviewHTML(review) {
        let html = `<div class="review-item" data-review-id="${review.id}">`;
        html += '<div class="review-header">';
        html += '<div class="reviewer-info">';
        html += '<div class="reviewer-avatar">';
        
        if (review.profile_img) {
            html += `<img src="./panels/admin/uploads/profile/${review.profile_img}" alt="${review.user_name}">`;
        } else {
            html += '<i class="fas fa-user-circle"></i>';
        }
        
        html += '</div>';
        html += '<div class="reviewer-details">';
        html += `<h5 class="reviewer-name">${review.user_name}</h5>`;
        html += `<span class="review-date">${review.created_at_formatted}</span>`;
        html += '</div></div>';
        html += '<div class="review-rating">';
        
        // Add stars
        for (let i = 1; i <= 5; i++) {
            if (i <= review.rating) {
                html += '<i class="fas fa-star"></i>';
            } else {
                html += '<i class="far fa-star"></i>';
            }
        }
        
        html += '</div></div>';
        html += `<h5 class="review-title">${review.review_title}</h5>`;
        html += `<p class="review-content">${review.review_content.replace(/\n/g, '<br>')}</p>`;
        html += '</div>';
        
        return html;
    }
    
    // Helper function to update review stats when a new review is added
    function updateReviewStats() {
        // Get current values
        const countElem = document.querySelector('.rating-count');
        if (!countElem) return;
        
        const currentCount = parseInt(countElem.textContent.match(/\d+/)[0]) || 0;
        
        // Update the count
        const newCount = currentCount + 1;
        countElem.textContent = `(${newCount} ${newCount === 1 ? 'review' : 'reviews'})`;
    }
    
    // Utility functions for messaging
    function showMessage(message, isError = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isError ? 'error' : 'success'}`;
        messageDiv.textContent = message;
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 3000);
    }
    
    function showLoading() {
        const loadingOverlay = document.querySelector('.loading-overlay');
        if (loadingOverlay) loadingOverlay.classList.add('active');
    }
    
    function hideLoading() {
        const loadingOverlay = document.querySelector('.loading-overlay');
        if (loadingOverlay) loadingOverlay.classList.remove('active');
    }
});