
<?php
require("connectdb.php");
require("food_db.php");

$msg = '';

$rank_restaurants = getRankRestaurants();



?>










<!DOCTYPE html>
<html lang="en">
<body>

<?php include "./src/header.html" ?>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-11" style='margin:auto'>

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <img class="d-block img-fluid" src="./img/food1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="./img/food2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="./img/food3.jpg" alt="Third slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>


      <div class="row" style = "padding-top:20px">

        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="icon-check m-auto text-primary"></i>
            </div>
            <h3><a href="./login.php">Sign in/Sign up</a></h3>
            <p class="lead mb-0">Sign in your account to start enjoy Strictly Charlottesville.</p>
            </div>

        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="icon-search-plus m-auto text-primary"></i>
            </div>
            <h3><a href="./search.php">Search Restaurant</a></h3>
            <p class="lead mb-0">Search your favorite restaurant and order your favorite dish.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="icon-shopping-bag m-auto text-primary"></i>
            </div>
            <h3><a href="./tracking.php">View Your Order</a></h3>
            <p class="lead mb-0">View your current order and estimate delivery time.</p>
          </div>
        </div>
      </div>
      
    
      <h3 style = "padding-top:40px">Top restaurants</h3>
        <div class="row" >
              <?php foreach ($rank_restaurants as $restaurant):
              $id = $restaurant['restaurantID'];
              $name = $restaurant['restaurant_name'];
              ?>

                <div class="col-lg-4 col-md-6 mb-4">
                  <div class="card h-100">

                    <!-- <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a> -->

                    <div class="card-body" >
                      <h4 class="card-title">
                      
                      <?php 
                      echo "<a href='./menu.php?id={$id}'>$name</a>";
                      ?>

                      </h4>
                      <h5><?php echo $restaurant['cuisine']; ?> </h5>
                      <p class="card-text"><?php echo $restaurant['restaurant_address']; ?> </p>
                    </div>

                    <div class="card-footer">
                      <p class="card-text">Average rating: <?php echo $restaurant['average_rating']; ?> </p>
                    </div>

                  </div>
                </div>
              <?php endforeach; ?>

        </div>
        <!-- end row -->

      </div>
      <!-- /.col-lg-9 -->

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
