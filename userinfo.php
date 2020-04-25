<?php session_start();?>

<?php
require('connectdb.php');
?>
<?php
if (isset($_GET['btn-save-changes']))
{
   try
   {
      switch ($_GET['btn-save-changes'])
      {
         case 'Save Changes': updateemail(); updateuserinfo(); updatepassword(); break;
      }
   }
   catch (Exception $e)       // handle any type of exception
   {
      $error_message = $e->getMessage();
      echo "<p>Error message: $error_message </p>";
   }
}
?>
<?php
//the following code will make all the current information (except for the password) accessible
//for the html so that the user may see it all the current information as placeholders
//so they can choose to change it or not
  require('connectdb.php');
  $query = "SELECT userID FROM users WHERE username = :un";
  $statement = $db->prepare($query);
  $statement->bindValue(':un', $_SESSION['user']);
  $statement->execute();
  $idresults = $statement->fetch();

  $fquery = "SELECT first_name FROM user WHERE userID = :userID";
  $statement = $db->prepare($fquery);
  $statement->bindValue(':userID', $idresults['userID']);
  $statement->execute();
  $fresults = $statement->fetch();

  $lquery = "SELECT last_name FROM user WHERE userID = :userID";
  $statement = $db->prepare($lquery);
  $statement->bindValue(':userID', $idresults['userID']);
  $statement->execute();
  $lresults = $statement->fetch();

  $equery = "SELECT email FROM users WHERE userID = :userID";
  $statement = $db->prepare($equery);
  $statement->bindValue(':userID', $idresults['userID']);
  $statement->execute();
  $eresults = $statement->fetch();

  $aquery = "SELECT address FROM user WHERE userID = :userID";
  $statement = $db->prepare($aquery);
  $statement->bindValue(':userID', $idresults['userID']);
  $statement->execute();
  $aresults = $statement->fetch();
  
  $pquery = "SELECT user_phone_number FROM user_phone_number WHERE userID = :userID";
  $statement = $db->prepare($pquery);
  $statement->bindValue(':userID', $idresults['userID']);
  $statement->execute();
  $presults = $statement->fetch();

  $cquery = "SELECT credit_card FROM customer_user_id WHERE userID = :userID";
  $statement = $db->prepare($cquery);
  $statement->bindValue(':userID', $idresults['userID']);
  $statement->execute();
  $cresults = $statement->fetch();

//once the save changes button is clicked, these functions will update the database
//with the information in the text fields
//updateuserinfo is all the basic ones
//the email function checks if the email exists and if not, then puts it in the db
//username cannot be changed, so we don't update that
//you can also update your password
function updateemail()
{
  require('connectdb.php');
  $query = "SELECT userID FROM users WHERE username = :un";
  $statement = $db->prepare($query);
  $statement->bindValue(':un', $_SESSION['user']);
  $statement->execute();
  $idresults = $statement->fetch();

  $email = $_GET['email'];
  $query2 = "SELECT username FROM users WHERE email = :email";
  $statement = $db->prepare($query2);
  $statement->bindValue(':email', $email);
  $statement->execute();
  $count = 0;
  while($result = $statement->fetch()){
    $count++;
    }
  if ($count!=0)
  {
    $query4 = "SELECT username FROM users WHERE email = :email";
    $statement = $db->prepare($query4);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $uresults = $statement->fetch();
    if ($uresults['username'] != $_SESSION['user']){
      echo "<p> Error: Email is Already Associated With an Account. </p>";
    } else {
      //donothing
    }
  } else {
    $query3 = "UPDATE users SET email = :email WHERE userID = :userID";
    $statement = $db->prepare($query3);
    $statement->bindValue(':userID', $idresults['userID']);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $statement->closeCursor();
    $statement->closeCursor();
  }
}
function updateuserinfo()
{
  require('connectdb.php');
  $first = $_GET['firstname'];
  $last = $_GET['lastname'];
  $address = $_GET['address'];
  $phone = $_GET['phone'];
  $cc = $_GET['creditcard'];

  $query = "SELECT userID FROM users WHERE username = :un";
  $statement = $db->prepare($query);
  $statement->bindValue(':un', $_SESSION['user']);
  $statement->execute();
  $idresults = $statement->fetch();

  $query2 = "UPDATE user SET first_name = :firstname, last_name = :lastname, address = :add WHERE userID = :userID";
  $statement = $db->prepare($query2);
  $statement->bindValue(':userID', $idresults['userID']);
  $statement->bindValue(':firstname', $first);
  $statement->bindValue(':lastname', $last);
  $statement->bindValue(':add', $address);
  $statement->execute();

  $fquery = "UPDATE user_phone_number SET user_phone_number = :phone WHERE userID = :userID";
  $statement = $db->prepare($fquery);
  $statement->bindValue(':userID', $idresults['userID']);
  $statement->bindValue(':phone', $phone);
  $statement->execute();

  $query4 = "UPDATE customer_user_id SET credit_card = :cc WHERE userID = :userID";
  $statement = $db->prepare($query4);
  $statement->bindValue(':userID', $idresults['userID']);
  $statement->bindValue(':cc', $cc);
  $statement->execute();
  $statement->closeCursor();
}
function updatepassword()
{
  require('connectdb.php');

  $query = "SELECT userID FROM users WHERE username = :un";
  $statement = $db->prepare($query);
  $statement->bindValue(':un', $_SESSION['user']);
  $statement->execute();
  $idresults = $statement->fetch();

  $pwd = $_GET['pwd'];
  $query2 = "UPDATE users SET pwd = :pwd WHERE userID = :userID";
  $statement = $db->prepare($query2);
  $statement->bindValue(':userID', $idresults['userID']);
  $statement->bindValue(':pwd', $pwd);
  $statement->execute();
  $statement->closeCursor();
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Food App Restaurant Form</title>
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
	          <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
	          <li class="nav-item active"><a href="contact.html" class="nav-link">Contact</a></li>
	          <li class="nav-item cta cta-colored"><a href="cart.html" class="nav-link"><span class="icon-shopping_cart"></span>[0]</a></li>

	        </ul>
	      </div>
	    </div>
    </nav>
    

    <section class="ftco-section contact-section bg-light">
<div class="container">
  <div class="row block-9">
    <div class="col-md-6 order-md-last d-flex">

  <form id="fm-userinfo" action="userinfo.php" method="GET" class="bg-white p-5 contact-form" onsubmit ="return checkPassword()" >
    <h1 class="navbar-brand" style="text-align:center">Edit User Information</h1>
    <label>First Name: </label> <div id="email-msg" class="feedback"></div> 
    <input type="text" name = "firstname" id="firstname" class="form-control" value = <?php echo $fresults['first_name']; ?> autofocus required />

    <label>Last Name: </label> <div id="email-msg" class="feedback"></div> 
    <input type="text" name = "lastname" id="lastname" class="form-control" value = <?php echo $lresults['last_name']; ?> autofocus required />

    <label>Email: </label> <div id="email-msg" class="feedback"></div> 
    <input type="email" name = "email" id="email" class="form-control" value = <?php echo $eresults['email']; ?> autofocus required />

    <label>Address: <?php echo $aresults['address']; ?></label> <div id="address-msg" class="feedback"></div> 
    <input type="text" name = "address" id="address" class="form-control" value = <?php echo $aresults['address']; ?> autofocus required />

    <label>Phone Number: </label> <div id="pn-msg" class="feedback"></div> 
    <input type="text" name = "phone" id="phone" pattern="[0-9]{10}" class="form-control" value = <?php echo $presults['user_phone_number']; ?> autofocus required />

    <label>Credit Card Number: </label> <div id="cc-msg" class="feedback"></div> 
    <input type="text" name = "creditcard" id="creditcard" pattern="[0-9]{16}" class="form-control" value = <?php echo $cresults['credit_card']; ?> autofocus required />

    <label>New Password: </label> <div id="pwd-msg" class="feedback"></div> 
    <input type="password" name = "pwd" id="pwd" placeholder = "Minimum Length: 8 characters" class="form-control" />

    <label>Re-enter Password: </label> <div id="reenterpwd-msg" class="feedback"></div> 
    <!-- displays an error message in the same spot as the other ones -->
    <div id="passwordErr" style="color:red; font-style: italic;" ></div>
    <input type="password" id="reenterpwd" placeholder = "Confirm Password" class="form-control" />
    
    <div>
      <input type="submit" value="Save Changes" style="margin-top:20px;" name = "btn-save-changes" class="btn btn-primary py-3 px-5" onclick=checkPassword() >
    </div>
  </form>
</div>
</div>
</div>
</section>

<script>
    //same as login page
    function validPassword() {
      var p_msg = document.getElementById("pwd-msg");
      if (this.value.length < 8 && this.value.length > 0)    	  
         p_msg.textContent = "Longer Password is Required.";
      else if (this.value.search(/\d/)==-1 && this.value.length > 0) 
        p_msg.textContent = "Must Contain at Least One Number.";
      else if (this.value.search(/[a-zA-Z]/)==-1 && this.value.length > 0) 
        p_msg.textContent = "Must Contain at Least One Letter.";
      else
        p_msg.textContent = "";
    }
// checks to see that the two passwords 
// inputted in the two boxes are the same
// if yes, nothing---if no, error message
function checkPassword(){
  var p_msg = document.getElementById("pwd");
  var rep_msg = document.getElementById("reenterpwd");
  if (rep_msg.value != "") {
      if(p_msg.value != rep_msg.value)
        document.getElementById("passwordErr").innerHTML = "The Passwords Do Not Match.";
      else
        document.getElementById("passwordErr").innerHTML = "";
  }
}

var pass = document.getElementById("pwd");
pass.addEventListener('blur', validPassword, false);

//checks the two inputted passwords to see if they're identical
var nom = document.getElementById("reenterpwd");
nom.addEventListener('blur', checkPassword, false);

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