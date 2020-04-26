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
  $query = "SELECT pwd FROM users WHERE username = :un";
  $statement = $db->prepare($query);
  $statement->bindValue(':un', $username);
  $statement->execute();
  $presults = $statement->fetch();
  if (password_verify($pwd, $presults['pwd']))
  {
    $query2 = "SELECT username FROM users WHERE username = :un AND pwd = :pwd";
    $statement = $db->prepare($query2);
    $statement->bindValue(':un', $username);
    $statement->bindValue(':pwd', $presults['pwd']);
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
      header('Location: home.php');
    }
  } else {
    echo "Invalid Password";
  }

}
?>


<!DOCTYPE html>
<html lang="en">
<?php include "./src/header.html" ?>

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
