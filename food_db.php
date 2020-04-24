<?php
function getAllRestaurants() {
  global $db;
  $query = "SELECT * FROM restaurant_info NATURAL JOIN restaurant_address
    NATURAL JOIN restaurant_contact";
  $statement = $db->prepare($query);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();
  return $results;
}

function getRestaurantById($id) {
  global $db;
  $query = "SELECT * FROM restaurant_info NATURAL JOIN restaurant_address
    NATURAL JOIN restaurant_contact
    WHERE restaurantID = :id";
  $statement = $db->prepare($query);
  $statement->bindValue (':id', $id);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closecursor();
	return $result;
}

function getMenuByResID($id) {
  global $db;
  $query = "SELECT * FROM food
    WHERE restaurantID = :id";
  $statement = $db->prepare($query);
  $statement->bindValue (':id', $id);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closecursor();
	return $results;
}

function getAllCuisines() {
  global $db;
  $query = "SELECT DISTINCT(cuisine) FROM restaurant_info";
  $statement = $db->prepare($query);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closecursor();
	return $results;
}

function insert_restaurant($res_name, $address, $phone, $cuisine, $hours) {
  global $db;
  $query = "INSERT INTO restaurant_address(restaurant_address)
            VALUES (:restaurant_address)";
  $statement = $db->prepare($query);
  $statement->bindValue (':restaurant_address', $address);
  $statement->execute();
  $statement->closecursor();

  $query = "INSERT INTO restaurant_info(restaurant_address, cuisine, hours, average_rating, res_phone_number)
            VALUES (:restaurant_address, :cuisine, :hours, 0, :res_phone_number)";
  $statement = $db->prepare($query);
  $statement->bindValue (':restaurant_address', $address);
  $statement->bindValue (':cuisine', $cuisine);
  $statement->bindValue (':hours', $hours);
  $statement->bindValue (':res_phone_number', $phone);
  $statement->execute();
  $statement->closecursor();

  $query = "INSERT INTO restaurant_contact(restaurant_name, res_phone_number)
            VALUES (:restaurant_name, :res_phone_number)";
  $statement = $db->prepare($query);
  $statement->bindValue (':restaurant_name', $res_name);
  $statement->bindValue (':res_phone_number', $phone);
  $statement->execute();
  $statement->closecursor();
}

function getUserIDbyUsername($username) {
  global $db;
  $query = "SELECT UserID FROM users WHERE username = :username";
  $statement = $db->prepare($query);
  $statement->bindValue (':username', $username);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closecursor();
	return $result;
}

function addFoodToCart($food_name, $price, $userID, $id, $foodItemID) {
  global $db;
  $query = "INSERT INTO food_temp(userID, itemID, food_name, price, restaurantID)
            VALUES (:userID, :itemID, :food_name, :price, :restaurantID)";
  $statement = $db->prepare($query);
  $userID = (int)$userID;
  $id = (int)$id;
  $foodItemID = (int)$foodItemID;
  $price = (float)$price;
  $statement->bindValue (':userID', $userID);
  $statement->bindValue (':itemID', $foodItemID);
  $statement->bindValue (':food_name', $food_name);
  $statement->bindValue (':price', $price);
  $statement->bindValue (':restaurantID', $id);
  $statement->execute();
  $statement->closecursor();
}

function removeFoodFromCart($userID, $res_id, $foodItemID) {
  global $db;
  $query = "DELETE FROM food_temp
            WHERE (userID = :userID AND itemID = :itemID AND restaurantID = :restaurantID)
            ORDER BY userID
            LIMIT 1";
    $statement = $db->prepare($query);
    $userID = (int)$userID;
    $res_id = (int)$res_id;
    $foodItemID = (int)$foodItemID;
    $statement->bindValue (':userID', $userID);
    $statement->bindValue (':restaurantID', $res_id);
    $statement->bindValue (':itemID', $foodItemID);
    $statement->execute();
    $statement->closecursor();
}


function getCart($userID, $res_id) {
  global $db;
  $query = "SELECT * FROM food_temp
            WHERE userID = :userID AND restaurantID = :res_id";
  $statement = $db->prepare($query);
  $statement->bindValue (':userID', $userID);
  $statement->bindValue (':res_id', $res_id);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closecursor();
	return $results;
}




?>
