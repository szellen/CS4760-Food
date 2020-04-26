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

function insertOrder($order_number, $tracking_info, $date, $total, $tip) {
  global $db;
  $query = "INSERT INFO food_order VALUES (:order_number, :tracking_info, :date, :total, :tip)";
  $statement = $db->prepare($query);
  $statement->bindValue(':order_number', $orderNumber);
  $statement->bindValue(':tracking_info', $trackingInfo);
  $statement->bindValue(':date', $orderTime);
  $statement->bindValue(':total', $total);
  $statement->bindValue(':tip', $tip);
  $statement->execute();
  $statement->closecursor();
}

$userInfo = getUserInfo($_SESSION['user']);


$foodName = $_POST['foodOrder'];
$foodQuantity = $_POST['foodQuantity'];
$foodPrice = $_POST['foodPrice'];

$totalPrice = 0;

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

      function updateTotal() {
        num1 = document.getElementById("quantity").value; console.log(num1);
        num2 = Number(document.getElementById("price").value); console.log(num2);
        document.getElementById("total").innerText = (num1 * num2).toFixed(2);
      }

      function deleteItem(element) {
        var table = document.getElementById('cart');
        var x = element.parentElement;
        x = x.parentElement;
        x.remove();

      }

      function getTotal() {
        $subotal = document.getElementById("finalPrice").value;
        $tax = document.getElementById("finalTax").value;
        $tip = document.getElementById("finalTip").value;
        document.getElementById("finalTotal").value = $subtotal + $tax + $tip;
      }


    </script>

<?php include "./src/header.html" ?>

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
                  <?php for($item=0; $item < count($_POST['foodOrder']); $item++) { ?>

						      <!-- <tr class="text-center">
						        <td class="product-remove" ><a href="#" onclick="deleteItem(this)"><span class="ion-ios-close"></span></a></td> -->

						        <td class="product-name">
						        	<h3><?php echo $foodName[$item]; ?></h3>
						        </td>

						        <td class="price">$<?php echo $foodPrice[$item]; ?></td>
                    <input type="hidden" id="price" value="<?php echo $foodPrice[$item]; ?>"/>

                    <!-- <td class="quantity">
						        	<div class="input-group mb-3">
					             	<input type="number" onclick="updateTotal()" id="quantity" name="quantity" class="quantity form-control input-number" value="<?php echo $foodQuantity[$item]?>" min="1" max="100">
					          	</div>
					          </td> -->

						        <!-- <td class="total" id="total">$<?php echo number_format($foodQuantity[$item]*$foodPrice[$item], 2); ?></td> -->
						      </tr><!-- END TR-->

                <?php $totalPrice += $foodPrice[$item];?>
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
      		    						<span>$<?php echo number_format($totalPrice, 2); ?></span>
                          <input type="hidden" name="finalPrice" id="finalPrice" value="<?php echo number_format($totalPrice, 2); ?>" />
      		    					</p>

      		    					<p class="d-flex">
      		    						<span>Tax</span>
      		    						<span>$<?php echo number_format($totalPrice *0.053, 2); ?></span>
                          <input type="hidden" name="finalTax" id="finalTax" value="<?php echo number_format($totalPrice *0.053, 2); ?>" />
      		    					</p>
      		    					<p class="d-flex">
      		    						<span>Tip</span>
      		    						<!-- <span>$<?php echo number_format($totalPrice * 0.1, 2); ?></span> -->
                          $<input type="text" name="finalTip" id="finalTip" value="<?php echo number_format($totalPrice * 0.1, 2); ?>" size="4" />
      		    					</p>
      		    					<hr>
      		    					<p class="d-flex total-price">
      		    						<span>Total</span>
      		    						<span>$<script>document.write(getTotal());</script></span>
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
