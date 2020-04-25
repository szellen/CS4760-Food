
<?php
require("connectdb.php");
require("food_db.php");

$msg = '';

$all_restaurants = getAllRestaurants();



?>










<!DOCTYPE html>
<html lang="en">
<body>

<?php include "./src/header.html" ?>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-11" style='margin:auto'>


    
      <h3>Your order status</h3>
      <p class="lead mb-0">order_number:</p>
      <p class="lead mb-0">Total:</p>
      <p class="lead mb-0">tracking information:</p>
      <p class="lead mb-0">Estimate Arrival Time:</p>

      <div id="googleMap" style="width:100%;height:400px;"></div>

    <script>
    function myMap() {
    var mapProp= {
    center:new google.maps.LatLng(51.508742,-0.120850),
    zoom:5,
    };
    var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
    }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>



      </div>
      <!-- /.col-lg-11 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <?php include "./src/footer.html" ?>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>



  
</body>

</html>
