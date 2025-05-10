<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php 


  $cities = $conn->query("SELECT * FROM cities ORDER BY price ASC LIMIT 4");
  $cities->execute();

  $allCities = $cities->fetchAll(PDO::FETCH_OBJ);



  //grapping countries

  $countries = $conn->query("SELECT * FROM countries");
  $countries->execute();

  $allCountries = $countries->fetchAll(PDO::FETCH_OBJ);

  // var_dump($allCountries);



?>

  <div class="page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h4>Discover Our Weekly Offers</h4>
          <h2>Amazing Prices &amp; More</h2>
        </div>
      </div>
    </div>
  </div>

  <div class="search-form">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <form id="search-form" method="POST" role="search" action="search.php">
            <div class="row">
              <div class="col-lg-2">
                <h4>Sort Deals By:</h4>
              </div>
              <div class="col-lg-4">
                  <fieldset>
                      <select name="country_id" class="form-select" aria-label="Default select example" id="chooseLocation" onChange="this.form.click()">
                          <option selected>Destinations</option>
                          <?php foreach($allCountries as $country) : ?>
                            <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
                          <?php endforeach; ?>
                      </select>
                  </fieldset>
              </div>
              <div class="col-lg-4">
                  <fieldset>
                      <select name="price" class="form-select" aria-label="Default select example" id="choosePrice" onChange="this.form.click()">
                          <option selected>Price Range</option>
                          <option value="100">Less than $100</option>
                          <option value="250">Less than $250</option>
                          <option value="500">Less than $500</option>
                          <option value="1000">Less than $1,000</option>
                          <option value="2500">Less than $2,500</option>
                      </select>
                  </fieldset>
              </div>
              <div class="col-lg-2">                        
                  <fieldset>
                      <button type="submit" name="submit" class="border-button">Search Results</button>
                  </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="amazing-deals">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading text-center">
            <h2>Best Weekly Offers In Each City</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
          </div>
        </div>
        <?php foreach($allCities  as $city) : ?>

          <div class="col-lg-6 col-sm-6">
            <div class="item">
              <div class="row">
                <div class="col-lg-6">
                  <div class="image">
                    <img src="<?php echo CITIESIMAGES; ?>/<?php echo $city->image; ?>" alt="">
                  </div>
                </div>
                <div class="col-lg-6 align-self-center">
                  <div class="content">
                    <span class="info">*Limited Offer Today</span>
                    <h4><?php echo $city->name; ?></h4>
                    <div class="row">
                      <div class="col-6">
                        <i class="fa fa-clock"></i>
                        <span class="list"><?php echo $city->trip_days; ?> days</span>
                      </div>
                      <div class="col-6">
                        <i class="fa fa-map"></i>
                        <span class="list">Daily Places</span>
                      </div>
                    </div>
                    <p>Limited Price: $<?php echo $city->price; ?> per person</p>
                    <?php if(isset($_SESSION['username'])) : ?>

                      <div class="main-button">
                        <a href="reservation.php?id=<?php echo $city->id; ?>">Make a Reservation</a>
                      </div>
                    <?php else : ?>
                      <p>login to make a reservation</p>
                    <?php endif; ?>  
                  </div>
                </div>
              </div>
            </div>
        </div>
        <?php endforeach; ?> 

       
      </div>
    </div>
  </div>

<!-- Deals Header -->
<section class="deals-header py-5 bg-primary text-white">
    <div class="container">
        <h1 class="text-center">Special Deals & Offers</h1>
        <p class="text-center lead">Find the best travel deals and exclusive offers for your next adventure.</p>
    </div>
</section>

<!-- Featured Deals -->
<section class="featured-deals py-5">
    <div class="container">
        <h2 class="text-center mb-4">Featured Deals</h2>
        <div class="row">
            <!-- Featured Deal Card -->
            <div class="col-md-6 mb-4">
                <div class="card deal-card">
                    <div class="position-relative">
                        <img src="/assets/images/deals/paris-special.jpg" class="card-img-top" alt="Paris Special">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-danger">-30%</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Paris Special Package</h5>
                        <p class="card-text">Experience the city of love with our exclusive Paris package. Includes hotel stay, city tour, and Eiffel Tower visit.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-decoration-line-through text-muted">$999</span>
                                <span class="text-primary fw-bold ms-2">$699</span>
                                <span class="text-muted">/person</span>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Valid until: Dec 31, 2024</small>
                            <a href="/deals/paris-special" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- More Featured Deals -->
            <div class="col-md-6 mb-4">
                <div class="card deal-card">
                    <div class="position-relative">
                        <img src="/assets/images/deals/tokyo-special.jpg" class="card-img-top" alt="Tokyo Special">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-danger">-25%</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Tokyo Explorer Package</h5>
                        <p class="card-text">Discover the perfect blend of tradition and modernity in Tokyo. Includes accommodation, guided tours, and cultural experiences.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-decoration-line-through text-muted">$1,299</span>
                                <span class="text-primary fw-bold ms-2">$974</span>
                                <span class="text-muted">/person</span>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Valid until: Dec 31, 2024</small>
                            <a href="/deals/tokyo-explorer" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Seasonal Offers -->
<section class="seasonal-offers py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Seasonal Offers</h2>
        <div class="row">
            <!-- Summer Deals -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-sun fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">Summer Getaways</h5>
                        <p class="card-text">Enjoy up to 40% off on selected summer destinations. Perfect for family vacations and beach holidays.</p>
                        <a href="/deals/summer" class="btn btn-outline-primary">View Deals</a>
                    </div>
                </div>
            </div>

            <!-- Winter Deals -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-snowflake fa-3x text-info mb-3"></i>
                        <h5 class="card-title">Winter Escapes</h5>
                        <p class="card-text">Special rates for winter destinations. Ski packages and cozy mountain retreats available.</p>
                        <a href="/deals/winter" class="btn btn-outline-primary">View Deals</a>
                    </div>
                </div>
            </div>

            <!-- Holiday Deals -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-gift fa-3x text-danger mb-3"></i>
                        <h5 class="card-title">Holiday Specials</h5>
                        <p class="card-text">Celebrate the holidays with our special packages. Limited time offers for festive destinations.</p>
                        <a href="/deals/holiday" class="btn btn-outline-primary">View Deals</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="newsletter py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h3>Get Exclusive Deals</h3>
                <p>Subscribe to our newsletter and be the first to know about our special offers and promotions.</p>
                <form action="/newsletter/subscribe" method="POST" class="row g-3 justify-content-center">
                    <div class="col-md-8">
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require "includes/footer.php"; ?>
