<?php
require("connectdb.php");
require("food_db.php");
session_start();


$id = $_GET["id"];
$restaurant = getRestaurantById($id);


if (!empty($_SESSION['user'])) {
  $userID = getUserIDbyUsername($_SESSION['user'])[0];
  $shoppingCart = getCart($userID, $id);
} else {
  $shoppingCart = array();
}


//return all the food items
$menu = getMenuByResID($id);


// function to update the cart
if (!empty($_POST["add"])) {
  if (empty($_SESSION['user'])) {
    echo "<script>alert('Log in First!');</script>";
  } else if (!empty($_POST["food_name"]) && !empty($_POST["price"]) && !empty($_POST["foodItemID"])) {
    echo gettype($_POST["price"]);
    echo gettype($_POST["foodItemID"]);
    addFoodToCart($_POST["food_name"], $_POST["price"], $userID, $id, $_POST["foodItemID"]);
    $shoppingCart = getCart($userID, $id);
  }
}

if (!empty($_POST["remove"])) {
  if (empty($_SESSION['user'])) {
    $msg = 'Log in first!';
  } else if (!empty($_POST["foodItemID"])) {
    removeFoodFromCart($userID, $id, $_POST["foodItemID"]);
    $shoppingCart = getCart($userID, $id);
  }
}

if (!empty($_POST["submit_order"])) {
  if (empty($_SESSION['user'])) {
    $msg = 'Log in first!';
  } else if (!empty($_POST["foodItemID"])) {
    removeFoodFromCart($userID, $id, $_POST["foodItemID"]);
    $shoppingCart = getCart($userID, $id);
  }
}

?>


<!DOCTYPE html>
<html lang="en">
    <?php include "./src/header.html" ?>

    <!-- END nav -->

    <!-- restaurant info -->
    <section class="ftco-section" style="padding: 1em 0">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 product-details pl-md-5 ftco-animate" style="padding-left:1rem !important">
            <h3><?php echo $restaurant["restaurant_name"]?></h3>
            <p class="text-left mr-4">
              <a class="mr-2"><?php echo $restaurant["cuisine"]?></a>
            </p>
            <div class="rating d-flex">
              <p class="text-left mr-4">
                <a href="#" class="mr-2"><?php echo $restaurant["average_rating"]?></a>
                <script>
                rating = "<?php echo $restaurant['average_rating']?>"
                if (rating >= 0 && rating <= 5) {
                            rating = Math.round(rating);
                            checked = '<a href="#"><span class="ion-ios-star"></span></a>';
                            unchecked = '<a href="#"><span class="ion-ios-star-outline"></span></a>';
                            document.write(checked.repeat(rating) + unchecked.repeat(5-rating));
                          } else{
                            document.write(unchecked.repeat(5));
                          }
                </script>
              </p>
            </div>
            <div class="block-23 mb-3">
	              <ul>
                  <li><span class="icon icon-phone"></span><span class="text"><?php echo $restaurant["res_phone_number"]?></span></li>
	                <li><span class="icon icon-map-marker"></span><span class="text"><?php echo $restaurant["restaurant_address"]?></span></li>
	              </ul>
	            </div>
            <p> Open Hours: <?php echo $restaurant["hours"] ?></p>

          </div>
        </div>
      </div>
    </section>





  <!-- Header
    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-9 ftco-animate text-center">
        	<p class="breadcrumbs"><span class="mr-2"><h href="index.html">Home</h></span> <span>Products</span></p>
          <h class="mb-0 bread" style="color:black; font-size:30px"><?php echo $restaurant["restaurant_name"]?></h>
          <p> </p>
          <h1 class="mb-0 bread" style="color:black; font-size:30px">Menu</h1>
        </div>
      </div>
    </div>
    -->

    <section class="ftco-section" style="padding: 1em 0">
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
          <input class = "form-control mb-4" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for food" title="Search for food">
          <script>
          function myFunction() {
              var input, filter, row, food_cards, h3, i, txtValue;
              input = document.getElementById("myInput");
              filter = input.value.toUpperCase();
              row = document.getElementById("row");
              food_cards = row.getElementsByClassName("col-md-6 col-lg-3 ftco-animate")
              for (i = 0; i < food_cards.length; i++) {
                  h3 = food_cards[i].getElementsByTagName("h3")[0];
                  txtValue = h3.textContent || h3.innerText;
                  if (txtValue.toUpperCase().indexOf(filter) > -1) {
                      food_cards[i].style.display = "";
                  } else {
                      food_cards[i].style.display = "none";
                  }
              }
          }
          </script>
        </div>

        <!-- Row -->
    		<div id = "row" class="row">
          <?php foreach ($menu as $food): ?>

            <div class="col-md-6 col-lg-3 ftco-animate">
      				<div class="product">
      					<!-- <a href="#" class="img-prod"><img class="img-fluid" src="images/product-1.jpg" alt="Colorlib Template"> -->
      						<!-- <span class="status">30%</span> -->
      						<div class="overlay"></div>
      					</a>
      					<div class="text py-3 pb-4 px-3 text-center">
      						<h3><?php echo $food['food_name']; ?></h3>
      						<div class="d-flex">
      							<div class="pricing">
  		    						<p class="price"><span class="price-sale">$<?php echo $food['price']; ?></span></p>
  		    					</div>
  	    					</div>
  	    					<div class="bottom-area d-flex px-3">
  	    						<div class="m-auto d-flex">
                      <form action="" method="post" style="margin-block-end: 0em">
                        <input type="hidden" name="food_name" value="<?php echo $food['food_name'] ?>" />
                        <input type="hidden" name="price" value="<?php echo $food['price'] ?>" />
                        <input type="hidden" name="foodItemID" value="<?php echo $food['itemID'] ?>" />
                        <input type="submit" name="add" value = "add" class="btn btn-primary" />
                      </form>
      							</div>
      						</div>
      					</div>
      				</div>
      			</div>
          <?php endforeach; ?>
    		</div>
        <!-- End row -->



        <!-- shopping cart -->
        <div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div class="cart-list">
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <th>Product List</th>
                    <th>Product Name</th>
						        <th>Price</th>
                    <th>Quantity</th>
						      </tr>
						    </thead>
						    <tbody>
                  <?php foreach ($shoppingCart as $food): ?>
  						      <tr class="text-center">
                      <td>
                      <form action="" method="post">
                        <input type="hidden" name="foodItemID" value="<?php echo $food['itemID'] ?>" />
                        <input type="submit" name="remove" value = "remove" class="btn btn-primary" />
                      </form>
                      </td>
  						        <td class="product-name">
  						        	<h3><?php echo $food["food_name"]?></h3>
  						        </td>
  						        <td class="price"><?php echo $food["price"]?></td>
  					          </td>
                      <td class="quantity">1</td>
  					          </td>
  						      </tr><!-- END TR-->
                  <?php endforeach; ?>
						    </tbody>
						  </table>
              <form action="order.php" method="post">
                <input style="float: right;" type="submit" name="submit_order" value = "Submit Order" class="btn btn-primary" />
                <input type="hidden" name="res_id" value="<?php echo $id ?>" />
                <input type="hidden" name="userID" value="<?php echo $userID ?>" />
              </form>
					  </div>
    			</div>
    		</div>



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