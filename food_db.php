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


?>
