<?php
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "food_waste_management"; 


$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$login_username = $_POST['username'];
$login_password = $_POST['password'];  

try {
    $sql = "SELECT * FROM Users WHERE username = :username OR email = :username"; 
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $login_username);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);  

    if ($user && password_verify($login_password, $user['password_hash'])) {
        session_start();
        $_SESSION['user_id'] = $user['user_id']; 
        $_SESSION['username'] = $user['username']; 
        echo "Login successful!";
    } else {
        echo "Invalid credentials!";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
