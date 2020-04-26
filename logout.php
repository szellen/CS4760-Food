<?php
require("connectdb.php");
require("food_db.php");
session_start();
session_destroy();
header("Location: home.php");

?>
