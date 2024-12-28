<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You need to log in!";
    exit;
}

$user_id = $_SESSION['user_id'];  


$servername = "localhost";
$username = "root";  
$password = "";     
$dbname = "food_waste_management"; 

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM Users WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);  

if ($user) {
    echo "Username: " . $user['username'] . "<br>";
    echo "First Name: " . $user['first_name'] . "<br>";
    echo "Last Name: " . $user['last_name'] . "<br>";
    echo "Email: " . $user['email'] . "<br>";
} else {
    echo "User not found!";
}
?>
