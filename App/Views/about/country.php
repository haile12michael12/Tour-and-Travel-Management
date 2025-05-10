<!-- Main Banner Area -->
<div class="about-main-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="content">
                    <div class="blur-bg"></div>
                    <h4>EXPLORE OUR COUNTRY</h4>
                    <div class="line-dec"></div>
                    <h2>Welcome To <?= htmlspecialchars($country->name) ?></h2>
                    <p><?= htmlspecialchars($country->description) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cities & Towns Section -->
<div class="cities-town">
    <div class="container">
        <div class="row">
            <div class="slider-content">
                <div class="row">
                    <div class="col-lg-12">
                        <h2><?= htmlspecialchars($country->name) ?>'s <em>Cities &amp; Towns</em></h2>
                    </div>
                    <div class="col-lg-12">
                        <div class="owl-cites-town owl-carousel">
                            <?php foreach ($citiesImages as $city): ?>
                                <div class="item">
                                    <div class="thumb">
                                        <img src="<?= CITIESIMAGES ?>/<?= htmlspecialchars($city->image) ?>" alt="<?= htmlspecialchars($city->name) ?>">
                                        <h4><?= htmlspecialchars($city->name) ?></h4>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Weekly Offers Section -->
<div class="weekly-offers">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="section-heading text-center">
                    <h2>Best Weekly Offers In Each City</h2>
                    <p>Discover amazing deals and packages for each city in <?= htmlspecialchars($country->name) ?>.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="owl-weekly-offers owl-carousel">
                    <?php foreach ($cities as $city): ?>
                        <div class="item">
                            <div class="thumb">
                                <img src="<?= CITIESIMAGES ?>/<?= htmlspecialchars($city->image) ?>" alt="<?= htmlspecialchars($city->name) ?>">
                                <div class="text">
                                    <h4>
                                        <?= htmlspecialchars($city->name) ?>
                                        <br>
                                        <span>
                                            <i class="fa fa-users"></i> 
                                            <?= $city->count_bookings ?> Check Ins
                                        </span>
                                    </h4>
                                    <h6>
                                        $<?= number_format($city->price, 2) ?>
                                        <br>
                                        <span>/person</span>
                                    </h6>
                                    <div class="line-dec"></div>
                                    <ul>
                                        <li>Deal Includes:</li>
                                        <li>
                                            <i class="fa fa-taxi"></i> 
                                            <?= $city->trip_days ?> Days Trip > Hotel Included
                                        </li>
                                        <li>
                                            <i class="fa fa-plane"></i> 
                                            Airplane Bill Included
                                        </li>
                                        <li>
                                            <i class="fa fa-building"></i> 
                                            Daily Places Visit
                                        </li>
                                    </ul>
                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <div class="main-button">
                                            <a href="/reservations/create?city_id=<?= $city->id ?>">Make a Reservation</a>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-center text-muted">
                                            <a href="/login">Login</a> to make a reservation
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- More About Section -->
<div class="more-about">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="left-image">
                    <img src="<?= htmlspecialchars($country->image) ?>" alt="<?= htmlspecialchars($country->name) ?>">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-heading">
                    <h2>Discover More About <?= htmlspecialchars($country->name) ?></h2>
                    <p>Experience the rich culture, beautiful landscapes, and warm hospitality of <?= htmlspecialchars($country->name) ?>.</p>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="info-item">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4><?= $numCities ?></h4>
                                    <span>Amazing Places</span>
                                </div>
                                <div class="col-lg-6">
                                    <h4><?= $numBookings ?></h4>
                                    <span>Different Check-ins</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p><?= htmlspecialchars($country->description) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Initialize Owl Carousel -->
<script>
$(document).ready(function() {
    $('.owl-cites-town').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: true,
        responsive: {
            0: { items: 1 },
            576: { items: 2 },
            992: { items: 3 }
        }
    });

    $('.owl-weekly-offers').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: true,
        responsive: {
            0: { items: 1 },
            768: { items: 2 },
            1200: { items: 3 }
        }
    });
});
</script> 