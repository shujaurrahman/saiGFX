document.addEventListener('DOMContentLoaded', function() {
    const profileImageForm = document.getElementById('profileImageForm');
    const profileImageInput = document.getElementById('profileImageInput');
    const profileImage = document.querySelector('#profileImageForm img');

    if (profileImageInput) {
        profileImageInput.addEventListener('change', function(e) {
            e.preventDefault();
            
            if (this.files && this.files[0]) {
                // Show loading state
                profileImage.style.opacity = '0.5';
                
                const formData = new FormData();
                formData.append('profile_image', this.files[0]);

                fetch('ajax/update-profile-image.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update image source with timestamp to prevent caching
                        profileImage.src = data.image_url + '?t=' + new Date().getTime();
                        showMessage('success', 'Profile image updated successfully');
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    showMessage('error', error.message || 'Failed to update profile image');
                })
                .finally(() => {
                    profileImage.style.opacity = '1';
                });
            }
        });
    }

    function showMessage(type, message) {
        // Remove existing messages
        const existingMessages = document.querySelectorAll('.alert');
        existingMessages.forEach(msg => msg.remove());

        // Create new message
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} animate__animated animate__fadeInUp`;
        alertDiv.textContent = message;

        // Insert message at the top of profile-info
        const container = document.querySelector('.profile-info');
        container.insertBefore(alertDiv, container.firstChild);

        // Auto remove success messages after 3 seconds
        if (type === 'success') {
            setTimeout(() => {
                alertDiv.classList.add('animate__fadeOutUp');
                setTimeout(() => alertDiv.remove(), 500);
            }, 3000);
        }
    }
});