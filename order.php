<?php

require("connectdb.php");

session_start();

$user = $_SESSION['user'];

$restaurantID = 1;

function getAllFood($restaurantID) {
  global $db;
  $query = "SELECT * FROM food";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $statement->closecursor();
  return $result;
}

$menu = getAllFood($restaurantID);

function getUserInfo($user) {
  global $db;
  $query = "SELECT * FROM user NATURAL JOIN users NATURAL JOIN user_phone_number WHERE username = :user";
  $statement = $db->prepare($query);
  $statement->bindValue(':user', $user);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closecursor();
  return $result;
}

$userInfo = getUserInfo($_SESSION['user']);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Food App</title>
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
    <link rel="stylesheet" href="order.css">

    <script>
      function shipDifferentAddress() {
        if(document.getElementById('ShipDifferent').checked) {
          document.getElementById('YesShipDifferent').style.visibility = 'visible';
          document.getElementById('YesShipDifferent').style.opacity = 1;
          document.getElementById('YesShipDifferent').style.maxHeight= '100%';
        }
        else {
          document.getElementById('YesShipDifferent').style.visibility = 'hidden';
          document.getElementById('YesShipDifferent').style.opacity = 0;
          document.getElementById('YesShipDifferent').style.maxHeight= 0;
        }
      }
    </script>

  </head>
  <body class="goto-here">
		<!-- <div class="py-1 bg-primary">
    	<div class="container">
    		<div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
	    		<div class="col-lg-12 d-block">
		    		<div class="row d-flex">
		    			<div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
						    <span class="text">+18045483722</span>
					    </div>
					    <div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
						    <span class="text">pm4by@virginia.edu</span>
					    </div>
					    <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
						    <span class="text">3-5 Business days delivery &amp; Free Returns</span>
					    </div>
				    </div>
			    </div>
		    </div>
		  </div>
    </div> -->
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.html">Strictly Charlottesville</a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item"><a href="index.html" class="nav-link">View Restaurants</a></li>
	          <li class="nav-item active dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop</a>
              <div class="dropdown-menu" aria-labelledby="dropdown04">
              	<!-- <a class="dropdown-item" href="shop.html">Menu</a>
              	<a class="dropdown-item" href="wishlist.html">Wishlist</a>
                <a class="dropdown-item" href="product-single.html">Single Product</a> -->
                <a class="dropdown-item" href="cart.html">Cart</a>
                <a class="dropdown-item" href="checkout.html">Checkout</a>
              </div>
            </li>
	          <!-- <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
	          <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
	          <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li> -->
	          <li class="nav-item cta cta-colored"><a href="cart.html" class="nav-link"><span class="icon-shopping_cart"></span>[0]</a></li>

	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->

    <!-- <div class="hero-wrap hero-bread" style="background-image: url('menu_template/images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Cart</span></p>
            <h1 class="mb-0 bread">My Cart</h1>
          </div>
        </div>
      </div>
    </div> -->

    <section class="ftco-section ftco-cart">
			<div class="container">
				<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div class="cart-list">
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <th>&nbsp;</th>

						        <th>Product name</th>
						        <th>Price</th>
						        <th>Quantity</th>
						        <th>Total</th>

						      </tr>
						    </thead>
						    <tbody>

                <form>
                  <?php foreach ($menu as $item): ?>
						      <tr class="text-center">
						        <td class="product-remove"><a href="#"><span class="ion-ios-close"></span></a></td>

						        <td class="product-name">
						        	<h3><?php echo $item['food_name']; ?></h3>
						        	<p><?php echo "restaurauntID: " . $item['restaurantID']; ?> </p>
						        </td>

						        <td class="price"><?php echo $item['price']; ?></td>

						        <td class="quantity">
						        	<div class="input-group mb-3">
					             	<input type="text" name="quantity" class="quantity form-control input-number" value="1" min="1" max="100">
					          	</div>
					          </td>

						        <td class="total"><?php echo $item['price']; ?></td>
						      </tr><!-- END TR-->
                  <? endforeach; ?>
                </form>

						      <!-- <tr class="text-center">
						        <td class="product-remove"><a href="#"><span class="ion-ios-close"></span></a></td>

						        <td class="product-name">
						        	<h3>Bell Pepper</h3>
						        	<p>Far far away, behind the word mountains, far from the countries</p>
						        </td>

						        <td class="price">$15.70</td>

						        <td class="quantity">
						        	<div class="input-group mb-3">
					             	<input type="text" name="quantity" class="quantity form-control input-number" value="1" min="1" max="100">
					          	</div>
					          </td>

						        <td class="total">$15.70</td>
						      </tr> END TR-->
						    </tbody>
						  </table>
					  </div>
    			</div>
    		</div>

    			<!-- <div class="col-lg-4 mt-5 cart-wrap ftco-animate">
    				<div class="cart-total mb-3">
    					<h3>Cart Totals</h3>
    					<p class="d-flex">
    						<span>Subtotal</span>
    						<span>$20.60</span>
    					</p>
    					<p class="d-flex">
    						<span>Delivery</span>
    						<span>$0.00</span>
    					</p>
    					<p class="d-flex">
    						<span>Discount</span>
    						<span>$3.00</span>
    					</p>
    					<hr>
    					<p class="d-flex total-price">
    						<span>Total</span>
    						<span>$17.60</span>
    					</p>
    				</div>
    				<p><a href="checkout.html" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>
    			</div> -->

          <!-- BILLING DETAILS -->

          <section class="ftco-section">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-xl-7 ftco-animate">

                  <form action="#" class="billing-form">
      							<h3 class="mb-4 billing-heading">Billing Details</h3>
      	          	<div class="row align-items-end">
      	          		<div class="col-md-6">
      	                <div class="form-group">
      	                	<label for="firstname">First Name</label>
      	                  <input type="text" class="form-control" placeholder="" value="<?php echo $userInfo[2]; ?>">
      	                </div>
      	              </div>
      	              <div class="col-md-6">
      	                <div class="form-group">
      	                	<label for="lastname">Last Name</label>
      	                  <input type="text" class="form-control" placeholder="" value="<?php echo $userInfo[3]; ?>">
      	                </div>
                      </div>
                      <div class="w-100"></div>
      		            <div class="col-md-12">
      		            	<div class="form-group">
      		            		<label for="country">State / Country</label>
      		            		<div class="select-wrap">
      		                  <div class="icon"><span class="ion-ios-arrow-down"></span></div>
      		                  <select name="" id="" class="form-control">
      		                  	<option value="">Virginia</option>
      		                  </select>
      		                </div>
      		            	</div>
      		            </div>
      		            <div class="w-100"></div>
      		            <div class="col-md-6">
      		            	<div class="form-group">
      	                	<label for="streetaddress">Street Address</label>
      	                  <input type="text" class="form-control" placeholder="" value="<?php echo $userInfo[1]; ?>">
      	                </div>
      		            </div>
      		            <div class="col-md-6">
      		            	<div class="form-group">
      	                  <input type="text" class="form-control" placeholder="Appartment, suite, unit etc: (optional)">
      	                </div>
      		            </div>
      		            <div class="w-100"></div>
      		            <div class="col-md-6">
      		            	<div class="form-group">
      	                	<label for="towncity">Town / City</label>
      	                  <input type="text" class="form-control" placeholder="Charlottesville" value="Charlottesville">
      	                </div>
      		            </div>
      		            <div class="col-md-6">
      		            	<div class="form-group">
      		            		<label for="postcodezip">Postcode / ZIP *</label>
      	                  <input type="text" class="form-control" placeholder="22904" value="22904">
      	                </div>
      		            </div>
      		            <div class="w-100"></div>
      		            <div class="col-md-6">
      	                <div class="form-group">
      	                	<label for="phone">Phone</label>
      	                  <input type="text" class="form-control" placeholder="" value="<?php echo $userInfo[7]; ?>">
      	                </div>
      	              </div>
      	              <div class="col-md-6">
      	                <div class="form-group">
      	                	<label for="emailaddress">Email Address</label>
      	                  <input type="text" class="form-control" placeholder="" value="<?php echo $userInfo[6]; ?>">
      	                </div>
                      </div>
                      <div class="w-100"></div>
                      <div class="col-md-12">
                      	<div class="form-group mt-4">
      										<div class="radio">
      										  <label class="mr-3"><input type="radio" name="optradio" id="CreateAccount" onclick="javascript:shipDifferentAddress()"> Create an Account? </label>
      										  <label><input type="radio" name="optradio" id="ShipDifferent" onclick="javascript:shipDifferentAddress()">Change Delivery Address</label>

      										</div>
      									</div>
                      </div>
      	            </div>
      	          </form><!-- END -->

                  <!-- SHIP TO DIFFERENT ADDRESS -->

                  <div id="YesShipDifferent" style="visibility: visible; opacity: 0; max-height: 0; ">
                  <form action="#" class="billing-form">
      							<h3 class="mb-4 billing-heading">Change Delivery Address</h3>
      	          	<div class="row align-items-end">
      	          		<div class="col-md-6">
      	                <div class="form-group">
      	                	<label for="firstname">First Name</label>
      	                  <input type="text" class="form-control" placeholder="<?php echo $userInfo[2]; ?>">
      	                </div>
      	              </div>
      	              <div class="col-md-6">
      	                <div class="form-group">
      	                	<label for="lastname">Last Name</label>
      	                  <input type="text" class="form-control" placeholder="<?php echo $userInfo[3]; ?>">
      	                </div>
                      </div>
                      <div class="w-100"></div>
      		            <div class="col-md-12">
      		            	<div class="form-group">
      		            		<label for="country">State / Country</label>
      		            		<div class="select-wrap">
      		                  <div class="icon"><span class="ion-ios-arrow-down"></span></div>
      		                  <select name="" id="" class="form-control">
      		                  	<option value="">Virginia</option>
      		                  </select>
      		                </div>
      		            	</div>
      		            </div>
      		            <div class="w-100"></div>
      		            <div class="col-md-6">
      		            	<div class="form-group">
      	                	<label for="streetaddress">Street Address</label>
      	                  <input type="text" class="form-control" placeholder="<?php echo $userInfo[1]; ?>">
      	                </div>
      		            </div>
      		            <div class="col-md-6">
      		            	<div class="form-group">
      	                  <input type="text" class="form-control" placeholder="Appartment, suite, unit etc: (optional)">
      	                </div>
      		            </div>
      		            <div class="w-100"></div>
      		            <div class="col-md-6">
      		            	<div class="form-group">
      	                	<label for="towncity">Town / City</label>
      	                  <input type="text" class="form-control" placeholder="Charlottesville">
      	                </div>
      		            </div>
      		            <div class="col-md-6">
      		            	<div class="form-group">
      		            		<label for="postcodezip">Postcode / ZIP *</label>
      	                  <input type="text" class="form-control" placeholder="22904">
      	                </div>
      		            </div>
      		            <div class="w-100"></div>
      		            <div class="col-md-6">
      	                <div class="form-group">
      	                	<label for="phone">Phone</label>
      	                  <input type="text" class="form-control" placeholder="<?php echo $userInfo[7]; ?>">
      	                </div>
      	              </div>
      	              <div class="col-md-6">
      	                <div class="form-group">
      	                	<label for="emailaddress">Email Address</label>
      	                  <input type="text" class="form-control" placeholder="" value="<?php echo $userInfo[6]; ?>">
      	                </div>
                      </div>
                      <div class="w-100"></div>

      	            </div>
      	          </form><!-- END -->
                </div>



      					</div>
      					<div class="col-xl-5">
      	          <div class="row mt-5 pt-3">
      	          	<div class="col-md-12 d-flex mb-5">
      	          		<div class="cart-detail cart-total p-3 p-md-4">
      	          			<h3 class="billing-heading mb-4">Cart Total</h3>
      	          			<p class="d-flex">
      		    						<span>Subtotal</span>
      		    						<span>$20.60</span>
      		    					</p>
      		    					<p class="d-flex">
      		    						<span>Delivery</span>
      		    						<span>$0.00</span>
      		    					</p>
      		    					<p class="d-flex">
      		    						<span>Discount</span>
      		    						<span>$3.00</span>
      		    					</p>
      		    					<hr>
      		    					<p class="d-flex total-price">
      		    						<span>Total</span>
      		    						<span>$17.60</span>
      		    					</p>
      								</div>
      	          	</div>
      	          	<div class="col-md-12">
      	          		<div class="cart-detail p-3 p-md-4">
      	          			<h3 class="billing-heading mb-4">Payment Method</h3>
      									<div class="form-group">
      										<div class="col-md-12">
      											<div class="radio">
      											   <label><input type="radio" name="optradio" class="mr-2"> Direct Bank Tranfer</label>
      											</div>
      										</div>
      									</div>
      									<div class="form-group">
      										<div class="col-md-12">
      											<div class="radio">
      											   <label><input type="radio" name="optradio" class="mr-2"> Check Payment</label>
      											</div>
      										</div>
      									</div>
      									<!-- <div class="form-group">
      										<div class="col-md-12">
      											<div class="radio">
      											   <label><input type="radio" name="optradio" class="mr-2"> Paypal</label>
      											</div>
      										</div>
      									</div> -->
      									<div class="form-group">
      										<div class="col-md-12">
      											<div class="checkbox">
      											   <label><input type="checkbox" value="" class="mr-2"> I have read and accept the terms and conditions</label>
      											</div>
      										</div>
      									</div>
      									<p><a href="#"class="btn btn-primary py-3 px-4">Place an order</a></p>
      								</div>
      	          	</div>
      	          </div>
                </div> <!-- .col-md-8 -->
              </div>
            </div>
          </section> <!-- .section -->


    		</div>
			</div>
		</section>

		<!-- <section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
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
    </section> -->
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
              <h2 class="ftco-heading-2">Strictly Charlottesville</h2>
              <p>Based in Charlottesville, Virginia.</p>
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
                <li><a href="#" class="py-2 d-block">View Restaurants</a></li>
                <li><a href="#" class="py-2 d-block">Cart</a></li>
                <li><a href="#" class="py-2 d-block">My Account</a></li>
                <!-- <li><a href="#" class="py-2 d-block">Contact Us</a></li> -->
              </ul>
            </div>
          </div>
          <!-- <div class="col-md-4">
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
          </div> -->
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">85 Engineers Way, Charlottesville, Virginia, USA</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">pm4by@virginia.edu</span></a></li>
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

  <script>
		$(document).ready(function(){

		var quantitiy=0;
		   $('.quantity-right-plus').click(function(e){

		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());

		        // If is not undefined

		            $('#quantity').val(quantity + 1);


		            // Increment

		    });

		     $('.quantity-left-minus').click(function(e){
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());

		        // If is not undefined

		            // Increment
		            if(quantity>0){
		            $('#quantity').val(quantity - 1);
		            }
		    });

		});
	</script>

  </body>
</html>
