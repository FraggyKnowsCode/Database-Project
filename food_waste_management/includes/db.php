<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_waste_management"; 

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
