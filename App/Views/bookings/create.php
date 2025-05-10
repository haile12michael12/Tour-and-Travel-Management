<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="card-title text-center mb-4">Create New Booking</h1>

                    <form action="/bookings/create" method="POST" id="bookingForm">
                        <!-- Destination Selection -->
                        <div class="mb-4">
                            <label for="city_id" class="form-label">Select Destination</label>
                            <select class="form-select" id="city_id" name="city_id" required>
                                <option value="">Choose a destination...</option>
                                <?php foreach ($cities as $city): ?>
                                    <option value="<?= $city->id ?>" data-price="<?= $city->price_per_person ?>">
                                        <?= $city->name ?>, <?= $city->country_name ?> - $<?= number_format($city->price_per_person, 2) ?> per person
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Deal Selection -->
                        <div class="mb-4">
                            <label for="deal_id" class="form-label">Select Deal (Optional)</label>
                            <select class="form-select" id="deal_id" name="deal_id">
                                <option value="">No deal selected</option>
                                <?php foreach ($deals as $deal): ?>
                                    <option value="<?= $deal->id ?>" data-discount="<?= $deal->discount_percentage ?>">
                                        <?= $deal->title ?> - <?= $deal->discount_percentage ?>% off
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Travel Date -->
                        <div class="mb-4">
                            <label for="travel_date" class="form-label">Travel Date</label>
                            <input type="date" class="form-control" id="travel_date" name="travel_date" 
                                   min="<?= date('Y-m-d') ?>" required>
                        </div>

                        <!-- Number of People -->
                        <div class="mb-4">
                            <label for="number_of_people" class="form-label">Number of People</label>
                            <input type="number" class="form-control" id="number_of_people" name="number_of_people" 
                                   min="1" max="10" value="1" required>
                        </div>

                        <!-- Price Summary -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Price Summary</h5>
                                <div class="row">
                                    <div class="col-6">Base Price:</div>
                                    <div class="col-6 text-end" id="basePrice">$0.00</div>
                                </div>
                                <div class="row">
                                    <div class="col-6">Discount:</div>
                                    <div class="col-6 text-end" id="discount">-$0.00</div>
                                </div>
                                <hr>
                                <div class="row fw-bold">
                                    <div class="col-6">Total Price:</div>
                                    <div class="col-6 text-end" id="totalPrice">$0.00</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check-circle me-2"></i>Confirm Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('bookingForm');
    const citySelect = document.getElementById('city_id');
    const dealSelect = document.getElementById('deal_id');
    const peopleInput = document.getElementById('number_of_people');
    
    function updatePrice() {
        const selectedCity = citySelect.options[citySelect.selectedIndex];
        const selectedDeal = dealSelect.options[dealSelect.selectedIndex];
        const numberOfPeople = parseInt(peopleInput.value);
        
        if (selectedCity.value) {
            const basePrice = parseFloat(selectedCity.dataset.price) * numberOfPeople;
            let discount = 0;
            
            if (selectedDeal.value) {
                const discountPercentage = parseFloat(selectedDeal.dataset.discount);
                discount = (basePrice * discountPercentage) / 100;
            }
            
            const totalPrice = basePrice - discount;
            
            document.getElementById('basePrice').textContent = `$${basePrice.toFixed(2)}`;
            document.getElementById('discount').textContent = `-$${discount.toFixed(2)}`;
            document.getElementById('totalPrice').textContent = `$${totalPrice.toFixed(2)}`;
        }
    }
    
    citySelect.addEventListener('change', updatePrice);
    dealSelect.addEventListener('change', updatePrice);
    peopleInput.addEventListener('input', updatePrice);
    
    // Initial price calculation
    updatePrice();
});
</script> 