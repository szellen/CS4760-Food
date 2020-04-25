<?php session_start();?>
<?php
require('connectdb.php');
?>
<?php
    function reject($entry){
      echo 'Error: Invalid input for ' . $entry;
      exit();
    }
    require('connectdb.php');
    if ($_SERVER['REQUEST_METHOD']=="POST" && strlen($_POST['username'])>0)
    {
      $user = trim($_POST['username']);
      if (!ctype_alnum($user)){
        reject('username');
      }
      if(isset($_POST['pwd'])){
        $pwd = trim($_POST['pwd']);
        if (!ctype_alnum($pwd)){
          reject('password');
        }
        else
        {
          $_SESSION['user'] = $user;
          $hash_pwd = password_hash($pwd, PASSWORD_BCRYPT);
          $_SESSION['pwd'] = $hash_pwd;
          checkpassword();
        }
      }
    }
?>
<?php
function checkpassword()
{
  require('connectdb.php');
  $username = $_POST['username'];
  $pwd = $_POST['pwd'];
  $query = "SELECT username FROM users WHERE username = :un AND pwd = :pwd";
  $statement = $db->prepare($query);
  $statement->bindValue(':un', $username);
  $statement->bindValue(':pwd', $pwd);
  $statement->execute();
  $count = 0;
  while($result = $statement->fetch()){
    $count++;
    }
  if ($count!=1)
  {
    echo "<p> Error: Incorrect Username and/or Password </p>";
  } else {
    $statement->closeCursor();
    header('Location: index.php');
  }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Food Login Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./menu_template/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="./menu_template/css/animate.css">

    <link rel="stylesheet" href="./menu_template/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./menu_template/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="./menu_template/css/magnific-popup.css">

    <link rel="stylesheet" href="./menu_template/css/aos.css">

    <link rel="stylesheet" href="./menu_template/css/ionicons.min.css">

    <link rel="stylesheet" href="./menu_template/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="./menu_template/css/jquery.timepicker.css">


    <link rel="stylesheet" href="./menu_template/css/flaticon.css">
    <link rel="stylesheet" href="./menu_template/css/icomoon.css">
    <link rel="stylesheet" href="./menu_template/css/style.css">
    <style>
      label { display: block; }
      .feedback { font-style: italic; color: red; }
  </style>
  </head>
  <body class="goto-here">
		<div class="py-1 bg-primary">
    	<div class="container">
    		<div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
	    		<div class="col-lg-12 d-block">
		    		<div class="row d-flex">
		    			<div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
						    <span class="text">+ 1 434 235 598</span>
					    </div>
					    <div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
						    <span class="text">strictlycville@gmail.com</span>
					    </div>
					    <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
						    <span class="text">Your Favorite Cville Food Delivery Service</span>
					    </div>
				    </div>
			    </div>
		    </div>
		  </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="search.php">Strictly Charlottesville</a></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item"><a href="index.html" class="nav-link">Home</a></li>
	          <li class="nav-item dropdown">
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
	          <li class="nav-item"><a href="userinfo.php" class="nav-link">User Information</a></li>
	          <li class="nav-item active"><a href="contact.html" class="nav-link">Contact</a></li>
	          <li class="nav-item cta cta-colored"><a href="cart.html" class="nav-link"><span class="icon-shopping_cart"></span>[0]</a></li>

	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->

<section class="ftco-section contact-section bg-light">
<div class="container">
  <div class="row block-9">
    <div class="col-md-6 order-md-last d-flex">
  <form id="fm-login" action="login.php" method="POST" class="bg-white p-5 contact-form" >
    <h1 style="text-align:center">Login</h1>
    <label>Username: </label> <div id="user-msg" class="feedback"></div> 
    <input type="text" name = "username" id="username" placeholder = "Enter Username" class="form-control" autofocus required />
    <label>Password: </label> <div id="pwd-msg" class="feedback"></div> 
    <input type="password" name = "pwd" id="pwd" placeholder = "Enter Password" class="form-control" required />
    <div>
      <!-- the buttons -->
      <input type="submit" style="margin-top:20px;" name="btn-submit" value="Register" class="btn btn-primary py-3 px-5" onclick = "return gotoreg()">

      <input type="submit" style="margin-top:20px; margin-left:20px;" name="btn-submit" value="Sign in" class="btn btn-primary py-3 px-5" >

    </div>
  </form>
</div>
</div>
</div>
</section>

<script>

  //validate username input by checking length
      function validUsername() {
      var u_msg = document.getElementById("user-msg");
      if (this.value.length < 8 && this.value.length > 0) {    	  
        u_msg.textContent = "Longer Username is Required.";
      }
      else {
         u_msg.textContent = "";
      }
    }
  //function to validate password input by checking length
  //function to also checks if it meets the numeric and character reqs
    function validPassword() {
      var p_msg = document.getElementById("pwd-msg");
      if (this.value.length < 8 && this.value.length > 0) {    	  
         p_msg.textContent = "Longer Password is Required.";
      }
      else if (this.value.search(/\d/)==-1 && this.value.length > 0) {
        p_msg.textContent = "Must Contain at Least One Number.";
      }
      else if (this.value.search(/[a-zA-Z]/)==-1 && this.value.length > 0) {
        p_msg.textContent = "Must Contain at Least One Letter.";
      }
      else {
         p_msg.textContent = "";
      }
    }
    //gets the inputted username
    var user = document.getElementById("username");
    user.addEventListener('blur', validUsername, false);
    //gets the inputted password
    var pass = document.getElementById("pwd");
    pass.addEventListener('blur', validPassword, false);

    function gotoreg(){
      alert("Going to Register as a New User!");
      window.location.href = "register.php";
    }
</script>

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
              <h2 class="ftco-heading-2">Vegefoods</h2>
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
	                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, Charlottesville, Virginia, USA</span></li>
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