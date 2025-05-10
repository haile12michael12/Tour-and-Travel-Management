<!-- Contact Header -->
<section class="contact-header py-5 bg-light">
    <div class="container">
        <h1 class="text-center">Contact Us</h1>
        <p class="text-center lead">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
    </div>
</section>

<!-- Contact Form and Info -->
<section class="contact-section py-5">
    <div class="container">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="/contact" method="POST" class="needs-validation" novalidate>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <div class="invalid-feedback">
                                        Please provide your name.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid email.
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                    <div class="invalid-feedback">
                                        Please provide a subject.
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                    <div class="invalid-feedback">
                                        Please provide your message.
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Contact Information</h5>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                123 Travel Street, City, Country
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-phone text-primary me-2"></i>
                                +1 234 567 890
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                info@tourandtravel.com
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Business Hours</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">Monday - Friday: 9:00 AM - 6:00 PM</li>
                            <li class="mb-2">Saturday: 10:00 AM - 4:00 PM</li>
                            <li>Sunday: Closed</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387193.30591910525!2d-74.25986432970718!3d40.697149422113014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1645564750985!5m2!1sen!2s" 
                            width="100%" 
                            height="450" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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