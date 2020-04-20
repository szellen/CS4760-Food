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
?>
