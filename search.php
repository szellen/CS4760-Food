<?php
require("connectdb.php");
require("food_db.php");
session_start();
$msg = '';

$all_restaurants = getAllRestaurants();
$all_cuisines = getAllCuisines();



if (!empty($_POST["cuisine_filter"])) {
  if ($_POST["cuisine_filter"] == "All" || $_POST["cuisine_filter"] == "Cuisine" ) {
    $all_restaurants = getAllRestaurants();
  } else {
    $all_restaurants = getRestaurantByCuisine($_POST["cuisine_filter"]);
    $result = $_POST["cuisine_filter"];
    ?> <script>document.getElementById("cuisine_filter").value = "<?php $result ?>" </script>
    <?php
  }
}


?>






<!DOCTYPE html>
<html lang="en">

  <body class="goto-here">

  <?php 
      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
          include "./src/header.html" ;
      } else {
          include "./src/header_guest.html" ;
}?>



    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-9 ftco-animate text-center">
        	<!-- <p class="breadcrumbs"><span class="mr-2"><h href="index.html">Home</h></span> <span>Products</span></p> -->
          <h class="mb-0 bread" style="color:black; font-size:30px">Restaurants</h>
        </div>
      </div>
    </div>


    <section class="ftco-section">

    	<div class="container">
        <!--
    		<div class="row justify-content-center">
    			<div class="col-md-10 mb-5 text-center">
    				<ul class="product-category">
    					<li><a href="#" class="active">All</a></li>
    					<li><a href="#">Vegetables</a></li>
    					<li><a href="#">Fruits</a></li>
    					<li><a href="#">Juice</a></li>
    					<li><a href="#">Dried</a></li>
    				</ul>
    			</div>
    		</div>
      -->


        <!-- Search bar  -->
        <div class="search_bar">
          <input class = "form-control mb-4" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for restaurants" title="Search for restaurants">
          <script>
          function myFunction() {
              var input, filter, row, res_cards, a, i, txtValue;
              input = document.getElementById("myInput");
              filter = input.value.toUpperCase();
              row = document.getElementById("row");
              res_cards = row.getElementsByClassName("col-lg-4 col-md-6 mb-4")
              for (i = 0; i < res_cards.length; i++) {
                  a = res_cards[i].getElementsByTagName("a")[1];
                  txtValue = a.textContent || a.innerText;
                  if (txtValue.toUpperCase().indexOf(filter) > -1) {
                      res_cards[i].style.display = "";
                  } else {
                      res_cards[i].style.display = "none";
                  }
              }
          }
          </script>


        </div>
        <!-- end search bar -->

        <!-- Filters -->

        <div class="row">
          <div class="col-lg-6 product-details pl-md-5 ftco-animate" style = "padding-left:1em">
                <div class="form-group d-flex">
                  <form action="search.php" method="post" style="width:100%; display:flex">
                    <div class="select-wrap">
                      <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                      <select name="cuisine_filter" id="cuisine_filter" class="form-control">
                        <option value="Cuisine" >Cuisine</option>
                        <option value="All" >All Cuisine</option>
                        <?php foreach ($all_cuisines as $cuisine): ?>
                          <option value="<?php echo $cuisine["cuisine"];?>"> <?php echo $cuisine["cuisine"];?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <button type="submit", name="apply_filter">Apply</button>
                  </form>
                </div>
            </div>

        </div>

        <script>
            function cuisineFilter(){
              var filter, row, res_cards, a, i, txtValue;
              var e = document.getElementById("cuisine_filter");
              var result = e.options[e.selectedIndex].text;
              //document.getElementById("result").innerHTML = result;
              filter = result.toUpperCase();
              row = document.getElementById("row");
              res_cards = row.getElementsByClassName("col-lg-4 col-md-6 mb-4")
              for (i = 0; i < res_cards.length; i++) {
                  if (result == 'Cuisine'){
                    res_cards[i].style.display = "";
                    continue
                  }
                  a = res_cards[i].getElementsByTagName("h5")[0];
                  txtValue = a.innerText;
                  if (txtValue.toUpperCase().indexOf(filter) > -1) {
                      res_cards[i].style.display = "";
                  } else {
                      res_cards[i].style.display = "none";
                  }
                }
          }
        </script>

        <!-- end Filters -->



        <div id = "row" class="row">
          <?php foreach ($all_restaurants as $restaurant): ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#"><img class="card-img-top"  alt=""></a>
              <!-- <a href="#"><img class="card-img-top" src="blue.jpg" alt="" style="width:700;height:400;"></a> -->
              <div class="card-body">
                <h4 class="card-title">
                  <script>
                  function getURL() {
                    url = "menu.php?id=" + "<?php echo $restaurant['id']?>"
                    document.write(url)
                  }
                  </script>
                  <a id = "res_url" href="menu.php?id=<?php echo $restaurant['restaurantID'];?>"> <?php echo $restaurant['restaurant_name']; ?></a>
                </h4>
                <h5><?php echo $restaurant['cuisine']?></h5>
                <p class="card-text"><?php echo $restaurant['restaurant_address']?></p>
              </div>
              <div class="card-footer">
                <script>
                rating = "<?php echo $restaurant['average_rating']?>"
                if (rating >= 0 && rating <= 5) {
                            rating = Math.round(rating);
                            checked = '<span class="fa fa-star checked"></span>';
                            unchecked = '<span class="fa fa-star"></span>';
                            document.write(checked.repeat(rating) + unchecked.repeat(5-rating));
                          } else{
                            document.write(unchecked.repeat(5));
                          }
                </script>
                <!-- <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small> -->
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
        .checked {
          color: orange;
        }
        </style>


    	</div>
    </section>

    <?php include "./src/footer.html" ?>


  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="menu_template/js/jquery.min.js"></script>
  <script src="menu_template/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="menu_template/js/popper.min.js"></script>
  <script src="menu_template/js/bootstrap.min.js"></script>
  <script src="menu_template/js/jquery.easing.1.3.js"></script>
  <script src="menu_template/js/jquery.waypoints.min.js"></script>
  <script src="menu_template/js/jquery.stellar.min.js"></script>
  <script src="menu_template/js/owl.carousel.min.js"></script>
  <script src="menu_template/js/jquery.magnific-popup.min.js"></script>
  <script src="menu_template/js/aos.js"></script>
  <script src="menu_template/js/jquery.animateNumber.min.js"></script>
  <script src="menu_template/js/bootstrap-datepicker.js"></script>
  <script src="menu_template/js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="menu_template/js/google-map.js"></script>
  <script src="menu_template/js/main.js"></script>

  </body>
</html>
