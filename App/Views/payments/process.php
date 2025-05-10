<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="card-title text-center mb-4">Process Payment</h1>

                    <!-- Booking Summary -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Booking Summary</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Destination:</strong><br>
                                        <?= htmlspecialchars($booking->city_name) ?>, 
                                        <?= htmlspecialchars($booking->country_name) ?>
                                    </p>
                                    <p class="mb-2">
                                        <strong>Travel Date:</strong><br>
                                        <?= date('F d, Y', strtotime($booking->travel_date)) ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Number of People:</strong><br>
                                        <?= $booking->number_of_people ?>
                                    </p>
                                    <p class="mb-2">
                                        <strong>Total Amount:</strong><br>
                                        $<?= number_format($booking->total_price, 2) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <form id="payment-form" class="needs-validation" novalidate>
                        <div class="mb-4">
                            <label for="card-element" class="form-label">Credit or Debit Card</label>
                            <div id="card-element" class="form-control"></div>
                            <div id="card-errors" class="invalid-feedback" role="alert"></div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="submit-button">
                                <i class="fas fa-lock me-2"></i>Pay $<?= number_format($booking->total_price, 2) ?>
                            </button>
                            <a href="/bookings/<?= $booking->id ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Booking
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>
<script>
// Initialize Stripe
const stripe = Stripe('<?= $stripeKey ?>');
const elements = stripe.elements();

// Create card Element
const card = elements.create('card', {
    style: {
        base: {
            fontSize: '16px',
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    }
});

// Mount card Element
card.mount('#card-element');

// Handle real-time validation errors
card.addEventListener('change', function(event) {
    const displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
        displayError.style.display = 'block';
    } else {
        displayError.textContent = '';
        displayError.style.display = 'none';
    }
});

// Handle form submission
const form = document.getElementById('payment-form');
const submitButton = document.getElementById('submit-button');

form.addEventListener('submit', async function(event) {
    event.preventDefault();
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';

    try {
        const {paymentMethod, error} = await stripe.createPaymentMethod({
            type: 'card',
            card: card,
        });

        if (error) {
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            errorElement.style.display = 'block';
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-lock me-2"></i>Pay $<?= number_format($booking->total_price, 2) ?>';
        } else {
            // Send payment method ID to server
            const response = await fetch('/payment/process/<?= $booking->id ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    payment_method_id: paymentMethod.id
                })
            });

            const result = await response.json();

            if (result.error) {
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error;
                errorElement.style.display = 'block';
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-lock me-2"></i>Pay $<?= number_format($booking->total_price, 2) ?>';
            } else {
                // Redirect to success page
                window.location.href = result.redirect_url;
            }
        }
    } catch (error) {
        console.error('Error:', error);
        const errorElement = document.getElementById('card-errors');
        errorElement.textContent = 'An unexpected error occurred.';
        errorElement.style.display = 'block';
        submitButton.disabled = false;
        submitButton.innerHTML = '<i class="fas fa-lock me-2"></i>Pay $<?= number_format($booking->total_price, 2) ?>';
    }
});
</script> 