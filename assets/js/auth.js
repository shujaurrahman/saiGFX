document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic validation
            const password = registerForm.querySelector('input[name="password"]').value;
            const email = registerForm.querySelector('input[name="email"]').value;
            const phone = registerForm.querySelector('input[name="phone"]').value;
            
            // Password validation
            if (password.length < 8) {
                showError('Password must be at least 8 characters long');
                return;
            }
            
            // Email validation
            if (!isValidEmail(email)) {
                showError('Please enter a valid email address');
                return;
            }
            
            // Phone validation
            if (!isValidPhone(phone)) {
                showError('Please enter a valid phone number');
                return;
            }
            
            // If all validations pass, submit the form
            this.submit();
        });
    }
    
    function showError(message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger animate__animated animate__fadeInUp';
        alertDiv.textContent = message;
        
        const existingAlert = document.querySelector('.alert');
        if (existingAlert) {
            existingAlert.remove();
        }
        
        registerForm.insertBefore(alertDiv, registerForm.firstChild);
    }
    
    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
    
    function isValidPhone(phone) {
        return /^\d{10}$/.test(phone.replace(/[^0-9]/g, ''));
    }
});