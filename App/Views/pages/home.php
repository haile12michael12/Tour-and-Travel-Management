<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold">Discover Your Next Adventure</h1>
                <p class="lead">Explore the world's most beautiful destinations with our curated travel experiences.</p>
                <div class="search-box mt-4">
                    <form action="/search" method="POST" class="row g-3">
                        <div class="col-md-5">
                            <select name="country_id" class="form-select" required>
                                <option value="">Select Destination</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?= $country->id ?>"><?= htmlspecialchars($country->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="price" class="form-select" required>
                                <option value="">Select Price Range</option>
                                <option value="100">Less than $100</option>
                                <option value="250">Less than $250</option>
                                <option value="500">Less than $500</option>
                                <option value="1000">Less than $1,000</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Destinations -->
<section class="featured-destinations py-5">
    <div class="container">
        <h2 class="text-center mb-4">Featured Destinations</h2>
        <div class="row">
            <?php foreach ($featuredDestinations as $destination): ?>
            <div class="col-md-4 mb-4">
                <div class="card destination-card">
                    <img src="/assets/images/destinations/<?= htmlspecialchars($destination->image) ?>" 
                         class="card-img-top" 
                         alt="<?= htmlspecialchars($destination->name) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($destination->name) ?>, <?= htmlspecialchars($destination->country_name) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($destination->description) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold">$<?= number_format($destination->price, 2) ?></span>
                            <a href="/destinations/<?= $destination->id ?>" class="btn btn-outline-primary">Explore</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Special Deals -->
<section class="special-deals py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Special Deals</h2>
        <div class="row">
            <?php foreach ($specialDeals as $deal): ?>
            <div class="col-md-6 mb-4">
                <div class="card deal-card">
                    <div class="position-relative">
                        <img src="/assets/images/deals/<?= htmlspecialchars($deal->image) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($deal->title) ?>">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-danger">-<?= $deal->discount_percentage ?>%</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($deal->title) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($deal->description) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-decoration-line-through text-muted">$<?= number_format($deal->original_price, 2) ?></span>
                                <span class="text-primary fw-bold ms-2">$<?= number_format($deal->discounted_price, 2) ?></span>
                            </div>
                            <small class="text-muted">Valid until: <?= date('M d, Y', strtotime($deal->valid_until)) ?></small>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="/deals/<?= $deal->id ?>" class="btn btn-primary w-100">Book Now</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Popular Countries -->
<section class="popular-countries py-5">
    <div class="container">
        <h2 class="text-center mb-4">Popular Countries</h2>
        <div class="row">
            <?php foreach ($popularCountries as $country): ?>
            <div class="col-md-4 col-lg-2 mb-4">
                <div class="card country-card text-center">
                    <img src="/assets/images/countries/<?= htmlspecialchars($country->image) ?>" 
                         class="card-img-top" 
                         alt="<?= htmlspecialchars($country->name) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($country->name) ?></h5>
                        <p class="card-text small text-muted"><?= $country->city_count ?> Cities</p>
                        <a href="/countries/<?= $country->id ?>" class="btn btn-sm btn-outline-primary">Explore</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="newsletter py-5 bg-primary text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h3>Subscribe to Our Newsletter</h3>
                <p>Get the latest travel deals and updates directly in your inbox.</p>
                <form action="/newsletter" method="POST" class="row g-3 justify-content-center">
                    <div class="col-md-8">
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-light w-100">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section> 