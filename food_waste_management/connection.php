<?php
$con = mysqli_connect("localhost", "root", "", "food_waste_management", port: 3307);
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>