<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="card-title text-center mb-4">Contact Us</h1>
                    
                    <p class="text-center text-muted mb-4">
                        Have questions about our tours or services? Fill out the form below and we'll get back to you as soon as possible.
                    </p>

                    <form action="/inquiries/create" method="POST" class="needs-validation" novalidate>
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="invalid-feedback">
                                Please enter your full name.
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                            <div class="invalid-feedback">
                                Please enter your phone number.
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                            <div class="invalid-feedback">
                                Please enter a subject for your inquiry.
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="mb-4">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            <div class="invalid-feedback">
                                Please enter your message.
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </div>
                    </form>

                    <!-- Contact Information -->
                    <div class="mt-5">
                        <h5 class="text-muted mb-3">Other Ways to Reach Us</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-phone text-primary me-3" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <h6 class="mb-0">Phone</h6>
                                        <p class="mb-0">+1 (555) 123-4567</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-envelope text-primary me-3" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <h6 class="mb-0">Email</h6>
                                        <p class="mb-0">info@tourandtravel.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script> 