document.addEventListener('DOMContentLoaded', function() {
    // Password strength validation
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const strengthBar = document.getElementById('strengthBar');
    const signupForm = document.getElementById('signupForm');

    const requirements = {
        length: document.getElementById('req-length'),
        uppercase: document.getElementById('req-uppercase'),
        lowercase: document.getElementById('req-lowercase'),
        number: document.getElementById('req-number')
    };

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;

        // Check length
        if (password.length >= 8) {
            requirements.length.classList.add('met');
            strength += 25;
        } else {
            requirements.length.classList.remove('met');
        }

        // Check uppercase
        if (/[A-Z]/.test(password)) {
            requirements.uppercase.classList.add('met');
            strength += 25;
        } else {
            requirements.uppercase.classList.remove('met');
        }

        // Check lowercase
        if (/[a-z]/.test(password)) {
            requirements.lowercase.classList.add('met');
            strength += 25;
        } else {
            requirements.lowercase.classList.remove('met');
        }

        // Check number
        if (/[0-9]/.test(password)) {
            requirements.number.classList.add('met');
            strength += 25;
        } else {
            requirements.number.classList.remove('met');
        }

        // Update strength bar
        strengthBar.style.width = strength + '%';
    });

    // Form validation on submit
    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            const email = document.getElementById('email').value;
            const fullName = document.getElementById('full_name').value;

            if (!fullName.trim()) {
                e.preventDefault();
                alert('Please enter your full name');
                return false;
            }

            if (!email.trim()) {
                e.preventDefault();
                alert('Please enter your email');
                return false;
            }

            if (!password) {
                e.preventDefault();
                alert('Please enter a password');
                return false;
            }

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match');
                return false;
            }


        });
    }
});
