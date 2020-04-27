<?php
require("connectdb.php");
require("food_db.php");
session_start();
$msg = '';

if (!empty($_SESSION['user'])) {
  $userID = getUserIDbyUsername($_SESSION['user'])[0];
  if (ifResOwner($userID) == 0) {
    echo "<script>alert('Need to register as a restaurant owner!');</script>";
  }
}



if (!empty($_POST['db-btn'])) {
  if ($_POST['db-btn'] == "Submit Restaurant Info") {
    if (!empty($_POST["res_name"]) && !empty($_POST["address"]) && !empty($_POST["phone"]) && !empty($_POST["cuisine"]) && !empty($_POST["hours"]) && !empty($_SESSION['user'])){
      insert_restaurant($_POST["res_name"], $_POST["address"], $_POST["phone"], $_POST["cuisine"], $_POST["hours"], $userID);
      echo "<script>alert('Success!');</script>";
    } else {
      echo "<script>alert('Info not complete!');</script>";
    }
  }
}



?>



<!DOCTYPE html>
<html lang="en">


<?php include "./src/header.html" ?>
    <!-- END nav -->


    <section class="ftco-section contact-section bg-light">
      <div class="container">
        <div class="row block-9">
          <div class="col-md-6 order-md-last d-flex" style="margin: auto;">

            <form action="restaurant_form.php" method="post" class="bg-white p-5 contact-form">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Restaurant Name" id="res_name" name="res_name">
              </div>
              <div class="form-group">
                <textarea name="address" id="address" cols="30" rows="4" class="form-control" placeholder="Address"></textarea>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Phone Number" id="phone" name="phone">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Cusine" id="cuisine" name="cuisine">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Hours" id="hours" name="hours">
              </div>
              <div class="form-group">
                <input type="submit" value="Submit Restaurant Info" name = "db-btn"class="btn btn-primary py-3 px-5">
              </div>
              <small class="text-danger"><?php echo $msg ?></small>
            </form>

          </div>
        </div>
      </div>
    </section>

    <?php include "./src/footer.html" ?>


  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="./menu_template/js/jquery.min.js"></script>
  <script src="./menu_template/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="./menu_template/js/popper.min.js"></script>
  <script src="./menu_template/js/bootstrap.min.js"></script>
  <script src="./menu_template/js/jquery.easing.1.3.js"></script>
  <script src="./menu_template/js/jquery.waypoints.min.js"></script>
  <script src="./menu_template/js/jquery.stellar.min.js"></script>
  <script src="./menu_template/js/owl.carousel.min.js"></script>
  <script src="./menu_template/js/jquery.magnific-popup.min.js"></script>
  <script src="./menu_template/js/aos.js"></script>
  <script src="./menu_template/js/jquery.animateNumber.min.js"></script>
  <script src="./menu_template/js/bootstrap-datepicker.js"></script>
  <script src="./menu_template/js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="./menu_template/js/google-map.js"></script>
  <script src="./menu_template/js/main.js"></script>

  </body>
</html>
