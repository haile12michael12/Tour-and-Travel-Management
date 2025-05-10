<!-- Footer -->
<footer class="footer bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>About Us</h5>
                <p>We are dedicated to providing the best travel experiences with our carefully curated destinations and exclusive deals.</p>
                <div class="social-links">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="/destinations" class="text-white">Destinations</a></li>
                    <li><a href="/deals" class="text-white">Special Deals</a></li>
                    <li><a href="/about" class="text-white">About Us</a></li>
                    <li><a href="/contact" class="text-white">Contact Us</a></li>
                    <li><a href="/privacy" class="text-white">Privacy Policy</a></li>
                    <li><a href="/terms" class="text-white">Terms & Conditions</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contact Info</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt me-2"></i> 123 Travel Street, City, Country</li>
                    <li><i class="fas fa-phone me-2"></i> +1 234 567 890</li>
                    <li><i class="fas fa-envelope me-2"></i> info@travel.com</li>
                </ul>
                <div class="mt-3">
                    <h6>Newsletter</h6>
                    <form action="/newsletter" method="POST" class="d-flex">
                        <input type="email" class="form-control me-2" name="email" placeholder="Enter your email" required>
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0">&copy; <?= date('Y') ?> Tour and Travel Management. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-end">
                <img src="/assets/images/payment-methods.png" alt="Payment Methods" height="30">
            </div>
        </div>
    </div>
</footer> 