<?php
require('connectdb.php');
?>
<?php
if (isset($_GET['btn-submit']))
{
   try
   {
      switch ($_GET['btn-submit'])
      {
         case 'Register': checkemail(); break;
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
$username = "";
$pwd = "";
$email ="";
function insertuserinfo()
{
  require('connectdb.php');
  $username = $_GET['username'];
  $pwd = $_GET['pwd'];
  $email = $_GET['email'];
  $query = "INSERT INTO users (username, pwd, email) VALUES (:username, :pwd, :email)";
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':pwd', $pwd);
  $statement->bindValue(':email', $email);
  $statement->execute();
  $statement->closeCursor();
}

function checkusername()
{
  require('connectdb.php');
  $username = $_GET['username'];
  $query = "SELECT username FROM users WHERE username = :un";
  $statement = $db->prepare($query);
  $statement->bindValue(':un', $username);
  $statement->execute();
  $count = 0;
  while($result = $statement->fetch()){
    $count++;
    }
  if ($count!=0)
  {
    echo "<p> Error: Username is Taken. </p>";
  } else {
    $statement->closeCursor();
    insertuserinfo();
    header('Location: login.php');
  }
}
function checkemail()
{
  require('connectdb.php');
  $email = $_GET['email'];
  $query = "SELECT username FROM users WHERE email = :email";
  $statement = $db->prepare($query);
  $statement->bindValue(':email', $email);
  $statement->execute();
  $count = 0;
  while($result = $statement->fetch()){
    $count++;
    }
  if ($count!=0)
  {
    echo "<p> Error: Email is Already Associated With an Account. </p>";
  } else {
    $statement->closeCursor();
    checkusername();
  }
}
require('register.html');
