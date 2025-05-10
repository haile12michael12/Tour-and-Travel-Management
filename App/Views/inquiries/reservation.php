<?php require_once 'App/Views/layouts/header.php'; ?>
<?php require "config/config.php"; ?>
<?php 

  if(!isset($_SESSION["username"])) {
    header("location: ".APPURL."");
  }

  if(isset($_GET['id'])) {

    $id = $_GET['id'];

    $city = $conn->query("SELECT * FROM cities WHERE id='$id'");
    $city->execute();

    $getCity = $city->fetch(PDO::FETCH_OBJ);

   


    if(isset($_POST['submit'])) {

      if(empty($_POST['name']) OR empty($_POST['phone_number']) OR empty($_POST['num_of_geusts']) 
      OR empty($_POST['checkin_date']) OR empty($_POST['destination'])) {
        echo "<script>alert('some inputs are empty');</script>";
      } else {

        $name = $_POST['name'];
        $phone_number = $_POST['phone_number'];
        $num_of_geusts = $_POST['num_of_geusts'];
        $checkin_date = $_POST['checkin_date'];
        $destination = $_POST['destination'];
        $status = "Pending";
        $city_id = $id;
        $user_id = $_SESSION['user_id'];

        $payment = $num_of_geusts * $getCity->price;

        $_SESSION['payment'] = $payment;
        
        if(date("Y-m-d") < $checkin_date) {
          $insert = $conn->prepare("INSERT INTO bookings (name, phone_number, num_of_geusts,
          checkin_date, destination, status, city_id, user_id, payment)
          VALUES (:name, :phone_number, :num_of_geusts, :checkin_date, :destination, :status,
          :city_id, :user_id, :payment)");
  
          $insert->execute([
            ":name" => $name,
            ":phone_number" => $phone_number,
            ":num_of_geusts" => $num_of_geusts,
            ":checkin_date" => $checkin_date,
            ":destination" => $destination,
            ":status" => $status,
            ":city_id" => $city_id,
            ":user_id" => $user_id,
            ":payment" => $payment,
          ]);

          header("location: pay.php");


        } else {
          echo "<script>alert('invalid date, pick starting from tomorrow');</script>";

        }
       
        
      // header("location: login.php");


      }
    }


  } else {
    header("location: 404.php");
  }

?>
  <div class="second-page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h4>Book Prefered Deal Here</h4>
          <h2>Make Your Reservation</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt uttersi labore et dolore magna aliqua is ipsum suspendisse ultrices gravida</p>
        </div>
      </div>
    </div>
  </div>

  <div class="more-info reservation-info">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-sm-6">
          <div class="info-item">
            <i class="fa fa-phone"></i>
            <h4>Make a Phone Call</h4>
            <a href="#">+123 456 789 (0)</a>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6">
          <div class="info-item">
            <i class="fa fa-envelope"></i>
            <h4>Contact Us via Email</h4>
            <a href="#">company@email.com</a>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6">
          <div class="info-item">
            <i class="fa fa-map-marker"></i>
            <h4>Visit Our Offices</h4>
            <a href="#">24th Street North Avenue London, UK</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Make a Reservation</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php 
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <form action="/reservation" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="city_id" class="form-label">Destination</label>
                                <select class="form-select" id="city_id" name="city_id" required>
                                    <option value="">Select Destination</option>
                                    <?php foreach ($cities as $city): ?>
                                        <option value="<?php echo $city->id; ?>">
                                            <?php echo htmlspecialchars($city->name); ?> - <?php echo htmlspecialchars($city->country_name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="check_in" class="form-label">Check In Date</label>
                                <input type="date" class="form-control" id="check_in" name="check_in" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="check_out" class="form-label">Check Out Date</label>
                                <input type="date" class="form-control" id="check_out" name="check_out" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="guests" class="form-label">Number of Guests</label>
                                <input type="number" class="form-control" id="guests" name="guests" min="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Additional Information</label>
                            <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit Reservation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum date for check-in to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('check_in').min = today;
    
    // Update check-out minimum date when check-in is selected
    document.getElementById('check_in').addEventListener('change', function() {
        document.getElementById('check_out').min = this.value;
    });
});
</script>

<?php require_once 'App/Views/layouts/footer.php'; ?>

