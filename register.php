<?php
require('connectdb.php');
?>
<?php

if (isset($_POST['btn-submit']))
{
   try
   {
      switch ($_POST['btn-submit'])
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
$first = "";
$last = "";
$address ="";
$phone = "";
$creditcard ="";
$userID = "";
function insertresowners()
{
  require('connectdb.php');
  if(isset($_POST['person'])){
    $person= $_POST['person'];
  } else {
    echo "<p> Error: No User Type Was Selected (can select 'Customer' or 'Restaurant Owner')</p>";
  }
  if ($person == "owner") {
    $username = $_POST['username'];
    $query = "SELECT userID FROM users WHERE username = :un";
    $statement = $db->prepare($query);
    $statement->bindValue(':un', $username);
    $statement->execute();
    $results = $statement->fetch();

    $query2 = "INSERT INTO restaurant_owner (userID) VALUES (:userID)";
    $statement = $db->prepare($query2);
    $statement->bindValue(':userID', $results['userID']);
    $statement->execute();
    $statement->closeCursor();
  } else {
    //do nothing
  }
}
function insertbasicinfo()
{
  require('connectdb.php');
  $username = $_POST['username'];
  $pwd = $_POST['pwd'];
  $email = $_POST['email'];
  $query = "INSERT INTO users (username, pwd, email) VALUES (:username, :pwd, :email)";
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':pwd', $pwd);
  $statement->bindValue(':email', $email);
  $statement->execute();
  $statement->closeCursor();
  insertuserinfo();
  insertresowners();
}
function insertuserinfo()
{
  require('connectdb.php');
  $username = $_POST['username'];
  $first = $_POST['firstname'];
  $last = $_POST['lastname'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $cc = $_POST['creditcard'];

  $query = "SELECT userID FROM users WHERE username = :un";
  $statement = $db->prepare($query);
  $statement->bindValue(':un', $username);
  $statement->execute();
  $results = $statement->fetch();

  $query2 = "INSERT INTO user (userID, address, first_name, last_name) VALUES (:userID, :add, :firstname, :lastname)";
  $statement = $db->prepare($query2);
  $statement->bindValue(':userID', $results['userID']);
  $statement->bindValue(':add', $address);
  $statement->bindValue(':firstname', $first);
  $statement->bindValue(':lastname', $last);
  $statement->execute();

  $query3 = "INSERT INTO user_phone_number (userID, user_phone_number) VALUES (:userID, :phone)";
  $statement = $db->prepare($query3);
  $statement->bindValue(':userID', $results['userID']);
  $statement->bindValue(':phone', $phone);
  $statement->execute();

  $query4 = "INSERT INTO customer_user_id (userID, credit_card) VALUES (:userID, :cc)";
  $statement = $db->prepare($query4);
  $statement->bindValue(':userID', $results['userID']);
  $statement->bindValue(':cc', $cc);
  $statement->execute();
  $statement->closeCursor();
}
function checkusername()
{
  require('connectdb.php');
  $username = $_POST['username'];
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
    insertbasicinfo();
    header('Location: login.php');
  }
}
function checkemail()
{
  require('connectdb.php');
  $email = $_POST['email'];
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
?>
