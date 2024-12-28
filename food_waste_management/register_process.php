<?php
$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "food_waste_management"; 

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_username = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];  
    $user_first_name = $_POST['first_name'];
    $user_last_name = $_POST['last_name'];

    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users (username, email, password_hash, first_name, last_name) 
            VALUES (:username, :email, :password_hash, :first_name, :last_name)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':username', $user_username);
    $stmt->bindParam(':email', $user_email);
    $stmt->bindParam(':password_hash', $hashed_password);
    $stmt->bindParam(':first_name', $user_first_name);
    $stmt->bindParam(':last_name', $user_last_name);

    $stmt->execute();

    echo "Registration successful!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
