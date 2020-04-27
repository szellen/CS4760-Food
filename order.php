<?php

require("connectdb.php");

session_start();

$user = $_SESSION['user'];

$restaurant_ID = $_POST['res_id'];
$userID = $_POST['userID'];

echo $_POST['res_id'];
echo $_POST['userID'];

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

function getOrder($userID, $restaurant_ID) {
  global $db;
  $query = "SELECT food_name FROM food_temp WHERE userID = :userID AND restaurantID = :restaurant_ID";
  $statement = $db->prepare($query);
  $statement->bindValue(':userID', $userID);
  $statement->bindValue(':restaurant_ID', $restaurant_ID);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closecursor();
  return $result;
}

function getPrice($userID, $restaurant_ID) {
  global $db;
  $query = "SELECT price FROM food_temp WHERE userID = :userID AND restaurantID = :restaurant_ID";
  $statement = $db->prepare($query);
  $statement->bindValue(':userID', $userID);
  $statement->bindValue(':restaurant_ID', $restaurant_ID);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closecursor();
  return $result;
}

$fullOrder = getOrder($userID, $restaurant_ID);
$fullPrice = getPrice($userID, $restaurant_ID);
$userInfo = getUserInfo($_SESSION['user']);
$subtotal = 0;
$total = 0;

function getCreditCard($userID) {
  global $db;
  $query = "SELECT credit_card FROM customers where userID = :userID";
  $statement = $db->prepare($query);
  $statement->bindValue(':userID', $userID);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closecursor();
  return $result;
}

echo getCreditCard($userID);

function addOrder($date, $total, $tip) {
  global $db;
  $query = "INSERT INTO food_order(date, total, tip)
            VALUES (:date, :total, :tip)";
  $statement = $db->prepare($query);
  $statement->bindValue(':date', $date);
  $statement->bindValue(':total', $total);
  $statement->bindValue(':tip', $tip);
  $statement->execute();
  $statement->closecursor();
}

if(!empty($_POST['submitOrder'])) {
  echo $_POST['submitDate'];
  echo $_POST['submitTotal'];
  echo $_POST['submitTip'];
  addOrder($_POST['submitDate'], $_POST['submitTotal'], $_POST['submitTip']);

}

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

      function validCheckingAccount() {
        if(document.getElementById('DirectBank').value == "") {
          alert("Please validate your checking account");
          document.getElementById('DirectBank').checked = false;
        }
        else {

        }
      }
    </script>

  </head>
  <body class="goto-here">

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.html">Strictly Charlottesville</a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item"><a href="home.php" class="nav-link">View Restaurants</a></li>
	          <li class="nav-item active dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop</a>
              <div class="dropdown-menu" aria-labelledby="dropdown04">

                <a class="dropdown-item" href="order.php">Cart</a>
                <!-- <a class="dropdown-item" href="checkout.html">Checkout</a> -->
              </div>
            </li>

	          <li class="nav-item cta cta-colored"><a href="cart.html" class="nav-link"><span class="icon-shopping_cart"></span>[0]</a></li>

	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->


    <section class="ftco-section ftco-cart">
			<div class="container">
				<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div class="cart-list">
	    				<table class="table" id="cart">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <!-- <th>&nbsp;</th> -->

						        <th>Product name</th>
						        <th>Price</th>
						        <!-- <th>Quantity</th> -->
						        <!-- <th>Total</th> -->

						      </tr>
						    </thead>
						    <tbody>

                <form>
                  <?php for($x=0; $x < count($fullOrder)-1; $x++) { ?>
                  <tr class="text-center">
						        <!-- <td class="product-remove" ><a href="#" onclick=""><span class="ion-ios-close"></span></a></td> -->

						        <td class="product-name">
						        	<h3><?php echo $fullOrder[$x]; ?></h3>
						        </td>

						        <td class="price">$<?php echo $fullPrice[$x]; ?></td>
                    <input type="hidden" id="price" value=""/>

                    <!-- <td class="quantity">
						        	<div class="input-group mb-3">
					             	<input type="number" onclick="updateTotal()" id="quantity" name="quantity" class="quantity form-control input-number" value="1" min="1" max="100" size="4">
					          	</div>
					          </td> -->

						        <!-- <td class="total" id="total">$</td> -->
                    <?php $subtotal += $fullPrice[$x]; ?>
						      </tr><!-- END TR-->
                <?php } ?>
                </form>


						    </tbody>
						  </table>
					  </div>
    			</div>
    		</div>



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

                        <form method="post" action="insertOrder()">
                        <p class="d-flex">
      		    						<span>Subtotal</span>
      		    						<span>$<?php echo number_format($subtotal, 2); ?></span>
                          <input type="hidden" name="finalPrice" id="finalPrice" value="<?php echo number_format($subtotal, 2); ?>" />
      		    					</p>

      		    					<p class="d-flex">
      		    						<span>Tax</span>
      		    						<span>$<?php echo number_format($subtotal *0.053, 2); ?></span>
                          <input type="hidden" name="finalTax" id="finalTax" value="<?php echo number_format($subtotal*0.053, 2); ?>" />
      		    					</p>
      		    					<p class="d-flex">
      		    						<span>Tip</span>
      		    						<!-- <span>$<?php echo number_format($totalPrice * 0.1, 2); ?></span> -->
                          $<input type="text" name="finalTip" id="finalTip" value="<?php echo number_format($subtotal* 0.1, 2); ?>" size="4" />
      		    					</p>
      		    					<hr>
      		    					<p class="d-flex total-price">
      		    						<span>Total</span>
      		    						<span>$<?php echo $total = number_format($subtotal, 2) +  number_format($subtotal *0.053, 2) + number_format($subtotal* 0.1, 2);?></span>
      		    					</p>
                      </form>
      								</div>
      	          	</div>
      	          	<div class="col-md-12">
      	          		<div class="cart-detail p-3 p-md-4">
      	          			<h3 class="billing-heading mb-4">Payment Method</h3>
      									<div class="form-group">
      										<div class="col-md-12">
      											<div class="radio">
      											   <label><input type="radio" name="optradio" id="DirectBank" class="mr-2" value="<?php echo getCreditCard($userID); ?>" onclick="validCheckingAccount()"> Direct Bank Tranfer</label>
      											</div>
      										</div>
      									</div>
      									<!-- <div class="form-group">
      										<div class="col-md-12">
      											<div class="radio">
      											   <label><input type="radio" name="optradio" class="mr-2"> Check Payment</label>
      											</div>
      										</div>
      									</div> -->
      									<div class="form-group">
      										<div class="col-md-12">
      											<div class="radio">
      											   <label><input type="radio" name="optradio" class="mr-2"> Paypal</label>
      											</div>
      										</div>
      									</div>
      									<div class="form-group">
      										<div class="col-md-12">
      											<div class="checkbox">
      											   <label><input type="checkbox" value="" class="mr-2"> I have read and accept the terms and conditions</label>
      											</div>
      										</div>
      									</div>
                        <form action="order.php" method="post">
                        <p><input type="submit" name="submitOrder" value="submit" class="btn btn-primary"/></p>
      									<!-- <p><a href="#"class="btn btn-primary py-3 px-4" name="submit">Place an order</a></p> -->
                        <input type="hidden" name="submitUserID" value="<?php echo $SESSION['user']?>" />
                        <input type="hidden" name="submitDate" value="<?php echo date("Y-m-d H:i:s")?>" />
                        <input type="hidden" name="submitTotal" value="<?php echo $total?>" />
                        <input type="hidden" name="submitTip" value="<?php echo number_format($subtotal*.1, 2)?>" />
                        <input type="hidden" name="res_id" value="<?php echo $restaurant_ID ?>" />
                        <input type="hidden" name="userID" value="<?php echo $userID ?>" />
                      </form>
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

          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">85 Engineers Way, Charlottesville, Virginia, USA</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+1234 567 8910</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">strictlycharlottesville@email.edu</span></a></li>
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
