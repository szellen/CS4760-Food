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
<?php include "./src/header.html" ?>

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
    <input type="text-area" name = "address" id="address" class="form-control" value = <?php echo $aresults['address']; ?> autofocus required />

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

<?php include "./src/footer.html" ?>

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