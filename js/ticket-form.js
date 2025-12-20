// Form validation
const form = document.getElementById('ticketForm');
const titleInput = document.getElementById('title');
const descriptionInput = document.getElementById('description');

// Add real-time validation
titleInput.addEventListener('blur', function() {
    const formGroup = this.closest('.form-group');
    if (this.value.trim().length < 5) {
        formGroup.classList.add('error');
        formGroup.classList.remove('success');
    } else {
        formGroup.classList.remove('error');
        formGroup.classList.add('success');
    }
});

descriptionInput.addEventListener('blur', function() {
    const formGroup = this.closest('.form-group');
    if (this.value.trim().length < 20) {
        formGroup.classList.add('error');
        formGroup.classList.remove('success');
    } else {
        formGroup.classList.remove('error');
        formGroup.classList.add('success');
    }
});

// Form submission
form.addEventListener('submit', function(e) {
    const title = titleInput.value.trim();
    const description = descriptionInput.value.trim();

    if (title.length < 5) {
        e.preventDefault();
        alert('Title must be at least 5 characters long');
        titleInput.focus();
        return;
    }

    if (description.length < 20) {
        e.preventDefault();
        alert('Description must be at least 20 characters long');
        descriptionInput.focus();
        return;
    }
});
