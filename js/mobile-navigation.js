document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu elements
    const mobileMenuTrigger = document.getElementById('mobileMenuTrigger');
    const mobileNavigation = document.getElementById('mobileNavigation');
    const mobileCloseBtn = document.getElementById('mobileCloseBtn');
    const mobileBackdrop = document.getElementById('mobileBackdrop');
    const categoryToggles = document.querySelectorAll('.mobile-category-toggle');
    
    // Open mobile menu
    if (mobileMenuTrigger) {
        mobileMenuTrigger.addEventListener('click', function() {
            mobileNavigation.classList.add('active');
            mobileBackdrop.classList.add('active');
            document.body.style.overflow = 'hidden';
            this.classList.add('active');
        });
    }
    
    // Close mobile menu
    function closeMenu() {
        mobileNavigation.classList.remove('active');
        mobileBackdrop.classList.remove('active');
        document.body.style.overflow = '';
        if (mobileMenuTrigger) {
            mobileMenuTrigger.classList.remove('active');
        }
    }
    
    if (mobileCloseBtn) {
        mobileCloseBtn.addEventListener('click', closeMenu);
    }
    
    if (mobileBackdrop) {
        mobileBackdrop.addEventListener('click', closeMenu);
    }
    
    // Category accordion
    categoryToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const subcategory = document.getElementById(targetId);
            
            // Toggle icon
            const icon = this.querySelector('i');
            
            if (subcategory.classList.contains('active')) {
                subcategory.classList.remove('active');
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            } else {
                subcategory.classList.add('active');
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        });
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 991 && mobileNavigation.classList.contains('active')) {
            closeMenu();
        }
    });
});