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

  $query = "INSERT INTO restaurant_info(restaurant_address, cuisine, hours, average_rating, res_phone_number)
            VALUES (:restaurant_address, :cuisine, :hours, 0, :res_phone_number)";
  $statement = $db->prepare($query);
  $statement->bindValue (':restaurant_address', $address);
  $statement->bindValue (':cuisine', $cuisine);
  $statement->bindValue (':hours', $hours);
  $statement->bindValue (':res_phone_number', $phone);
  $statement->execute();

  $query = "INSERT INTO restaurant_contact(restaurant_name, res_phone_number)
            VALUES (:restaurant_name, :res_phone_number)";
  $statement = $db->prepare($query);
  $statement->bindValue (':restaurant_name', $res_name);
  $statement->bindValue (':res_phone_number', $phone);
  $statement->execute();
}



?>
