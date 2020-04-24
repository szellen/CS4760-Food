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
session_destroy();

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Vegefoods - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="menu_template/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="menu_template/css/animate.css">

    <link rel="stylesheet" href="menu_template/css/owl.carousel.min.css">
    <link rel="stylesheet" href="menu_template/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="menu_template/css/magnific-popup.css">

    <link rel="stylesheet" href="menu_template/css/aos.css">

    <link rel="stylesheet" href="menu_template/css/ionicons.min.css">

    <link rel="stylesheet" href="menu_template/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="menu_template/css/jquery.timepicker.css">


    <link rel="stylesheet" href="menu_template/css/flaticon.css">
    <link rel="stylesheet" href="menu_template/css/icomoon.css">
    <link rel="stylesheet" href="menu_template/css/style.css">
  </head>
  <body class="goto-here">
		<div class="py-1 bg-primary">
    	<div class="container">
    		<div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
	    		<div class="col-lg-12 d-block">
		    		<div class="row d-flex">
		    			<div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
						    <span class="text">+ 1235 2355 98</span>
					    </div>
					    <div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
						    <span class="text">youremail@email.com</span>
					    </div>
					    <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
						    <span class="text">3-5 Business days delivery &amp; Free Returns</span>
					    </div>
				    </div>
			    </div>
		    </div>
		  </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="search.php">Food App</a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item"><a href="index.html" class="nav-link">Home</a></li>
	          <li class="nav-item active dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop</a>
              <div class="dropdown-menu" aria-labelledby="dropdown04">
              	<a class="dropdown-item" href="shop.html">Shop</a>
              	<a class="dropdown-item" href="wishlist.html">Wishlist</a>
                <a class="dropdown-item" href="product-single.html">Single Product</a>
                <a class="dropdown-item" href="cart.html">Cart</a>
                <a class="dropdown-item" href="checkout.html">Checkout</a>
              </div>
            </li>
	          <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
	          <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
	          <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
	          <li class="nav-item cta cta-colored"><a href="cart.html" class="nav-link"><span class="icon-shopping_cart"></span>[0]</a></li>

	        </ul>
	      </div>
	    </div>
	  </nav>
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
                <a href="#" class="mr-2">5.0</a>
                <a href="#"><span class="ion-ios-star"></span></a>
                <a href="#"><span class="ion-ios-star-outline"></span></a>
                <a href="#"><span class="ion-ios-star-outline"></span></a>
                <a href="#"><span class="ion-ios-star-outline"></span></a>
                <a href="#"><span class="ion-ios-star-outline"></span></a>
              </p>
              <p class="text-left mr-4">
                <a class="mr-2" style="color: #000;">1000 <span style="color: #bbb;">Ratings</span></a>
              </p>
              <p class="text-left">
                <a href="#" class="mr-2" style="color: #000;">500 <span style="color: #bbb;"></span></a>
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
              <form action="" method="post">
                <input style="float: right;" type="submit" name="submit_order" value = "Submit Order" class="btn btn-primary" />
              </form>
					  </div>
    			</div>
    		</div>


    		<div class="row mt-5">
          <div class="col text-center">
            <div class="block-27">
              <ul>
                <li><a href="#">&lt;</a></li>
                <li class="active"><span>1</span></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">&gt;</a></li>
              </ul>
            </div>
          </div>
        </div>
    	</div>
    </section>

		<section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
      <div class="container py-4">
        <div class="row d-flex justify-content-center py-5">
          <div class="col-md-6">
          	<h2 style="font-size: 22px;" class="mb-0">Subcribe to our Newsletter</h2>
          	<span>Get e-mail updates about our latest shops and special offers</span>
          </div>
          <div class="col-md-6 d-flex align-items-center">
            <form action="#" class="subscribe-form">
              <div class="form-group d-flex">
                <input type="text" class="form-control" placeholder="Enter email address">
                <input type="submit" value="Subscribe" class="submit px-3">
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <footer class="ftco-footer ftco-section">
      <div class="container">
      	<div class="row">
      		<div class="mouse">
						<a href="#" class="mouse-icon">
							<div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
						</a>
					</div>
      	</div>
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Food App</h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Menu</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">Shop</a></li>
                <li><a href="#" class="py-2 d-block">About</a></li>
                <li><a href="#" class="py-2 d-block">Journal</a></li>
                <li><a href="#" class="py-2 d-block">Contact Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Help</h2>
              <div class="d-flex">
	              <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
	                <li><a href="#" class="py-2 d-block">Shipping Information</a></li>
	                <li><a href="#" class="py-2 d-block">Returns &amp; Exchange</a></li>
	                <li><a href="#" class="py-2 d-block">Terms &amp; Conditions</a></li>
	                <li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
	              </ul>
	              <ul class="list-unstyled">
	                <li><a href="#" class="py-2 d-block">FAQs</a></li>
	                <li><a href="#" class="py-2 d-block">Contact</a></li>
	              </ul>
	            </div>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</p>
          </div>
        </div>
      </div>
    </footer>






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
