<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Food Login Title</title>
    <link rel="stylesheet" type="text/css" href="login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        label { display: block; }
        .feedback { font-style: italic; color: red; }*/
    </style>
</head>
<body style="background-color: #fff0b3;" onload="setFocus()">
<header>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <a style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 
  'Lucida Sans', Arial, sans-serif; font-size:xx-large" class="navbar-brand" 
  href="homepage.html">Food Title</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">   
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="homepage.php">Home</a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>                        
      <li class="nav-item"> 
        <a class="nav-link" href="#">Contact Us</a>
      </li>          
    </ul>
  </div>  
</nav>
</header>
<div class="container">
  <form id="fm-login" action="login.php" method="post">
    <!-- onsubmit = "return redirect()" -->
    <h1 style="text-align:center">Login</h1>
    <label>Username: </label> <div id="user-msg" class="feedback"></div> 
    <input type="text" name = "username" id="username" placeholder = "Enter Username" class="form-control" autofocus required />
    <label>Password: </label> <div id="pwd-msg" class="feedback"></div> 
    <input type="password" name = "pwd" id="pwd" placeholder = "Enter Password" class="form-control" required />
    <div>
      <!-- the buttons -->
      <input type="submit" name="btn-submit" value="Register" class="btn btn-dark" onclick = "return gotoreg()">
      <!-- onclick = "return gotoreg()" -->
      <input type="submit" name="btn-submit" value="Sign in" class="btn btn-dark">
      <!-- onsubmit = "return href=homepage.html" -->
    </div>
  </form>
</div>
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
    //header('Location: foodpage.php');
  }
}
?>
<!--put the php stuff above this part, it won't run otherwise because the script section deals with output and sends the headers-->
<script>
  //function to see if any id in the login box is being focused on
  var starter = document.getElementById("fm-login");
  starter.addEventListener("focusin", focuser);
  //starter.addEventListener("focusout", nomorefocus);
    //if so, it'll change the color of the boxes
  function focuser() {
    document.getElementById("username").style.backgroundColor = "#ccffff | transparent";
    document.getElementById("pwd").style.backgroundColor = "#ccffff | transparent";
  }
  //if not, it won't have any color in the boxes
  function nomorefocus() {
    document.getElementById("username").style.backgroundColor = "";
    document.getElementById("pwd").style.backgroundColor = "";
  }
  //validate username input by checking length
      function validUsername() {
      var u_msg = document.getElementById("user-msg");
      if (this.value.length < 8 && this.value.length > 0) {    	  
        u_msg.textContent = "Longer Username is Required.";
        //if not long enough and focus is on, change color
        document.getElementById("username").style.backgroundColor = "#ff6600";
      }
      else {
         u_msg.textContent = "";
         document.getElementById("username").style.backgroundColor = "#ccffff";
      }
    }
  //function to validate password input by checking length
  //function to also checks if it meets the numeric and character reqs
    function validPassword() {
      var p_msg = document.getElementById("pwd-msg");
      if (this.value.length < 8 && this.value.length > 0) {    	  
         p_msg.textContent = "Longer Password is Required.";
         //if not long enough and focus is on, change color
         document.getElementById("pwd").style.backgroundColor = "#ff6600";
      }
      else if (this.value.search(/\d/)==-1 && this.value.length > 0) {
        p_msg.textContent = "Must Contain at Least One Number.";
        document.getElementById("pwd").style.backgroundColor = "#ff6600";
      }
      else if (this.value.search(/[a-zA-Z]/)==-1 && this.value.length > 0) {
        p_msg.textContent = "Must Contain at Least One Letter.";
        document.getElementById("pwd").style.backgroundColor = "#ff6600";
      }
      else {
         p_msg.textContent = "";
         document.getElementById("pwd").style.backgroundColor = "#ccffff";
      }
    }
    //gets the inputted username, checks focus
    var user = document.getElementById("username");
    user.addEventListener('blur', validUsername, false);
    user.addEventListener('focusin', validUsername);
    user.addEventListener('focusout', validUsername);
    //gets the inputted password, checks focus
    var pass = document.getElementById("pwd");
    pass.addEventListener('blur', validPassword, false);
    pass.addEventListener('focusin', validPassword);
    pass.addEventListener('focusout', validPassword);

    function gotoreg(){
      alert("Going to Register as a New User!");
      window.location.href = "register.php";
    }
</script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- so we can toggle down -->
<script>
  $(document).ready(function() {
      $('.header').height($(window).height()/2.5);     
    })
</script>
</body>
</html>
<?php
?>