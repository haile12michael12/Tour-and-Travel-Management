document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Form validation
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Auto-hide alerts
    var alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 300);
        }, 5000);
    });

    // Add smooth transitions to alerts
    alerts.forEach(function(alert) {
        alert.style.transition = 'opacity 0.3s ease-in-out';
    });

    // Search form handling
    var searchForm = document.querySelector('form[action="/search"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(event) {
            var destination = this.querySelector('input[name="destination"]').value;
            var date = this.querySelector('input[name="date"]').value;
            
            if (!destination && !date) {
                event.preventDefault();
                alert('Please enter at least one search criteria');
            }
        });
    }

    // Newsletter subscription
    var newsletterForm = document.querySelector('form[action="/newsletter/subscribe"]');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(event) {
            event.preventDefault();
            var email = this.querySelector('input[name="email"]').value;
            
            // TODO: Add AJAX call to handle subscription
            console.log('Subscribing email:', email);
            
            // Show success message
            var successAlert = document.createElement('div');
            successAlert.className = 'alert alert-success';
            successAlert.textContent = 'Thank you for subscribing to our newsletter!';
            this.parentNode.insertBefore(successAlert, this);
            
            // Clear form
            this.reset();
        });
    }

    // Contact form handling
    var contactForm = document.querySelector('form[action="/contact"]');
    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            // TODO: Add form validation and AJAX submission
            var formData = new FormData(this);
            console.log('Submitting contact form:', Object.fromEntries(formData));
            
            // Show success message
            var successAlert = document.createElement('div');
            successAlert.className = 'alert alert-success';
            successAlert.textContent = 'Thank you for your message. We will get back to you soon!';
            this.parentNode.insertBefore(successAlert, this);
            
            // Clear form
            this.reset();
        });
    }

    // Add active class to current menu item
    var currentPath = window.location.pathname;
    var menuItems = document.querySelectorAll('.navbar-nav .nav-link');
    menuItems.forEach(function(item) {
        if (item.getAttribute('href') === currentPath) {
            item.classList.add('active');
        }
    });

    // Image lazy loading
    var lazyImages = document.querySelectorAll('img[loading="lazy"]');
    if ('loading' in HTMLImageElement.prototype) {
        lazyImages.forEach(function(img) {
            img.src = img.dataset.src;
        });
    } else {
        // Fallback for browsers that don't support lazy loading
        var lazyLoadScript = document.createElement('script');
        lazyLoadScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
        document.body.appendChild(lazyLoadScript);
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(event) {
            event.preventDefault();
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}); 