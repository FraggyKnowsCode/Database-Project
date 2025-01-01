<?php
require 'connect.php';

if (isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];

    $foodSql = "SELECT food_category, amount_wasted FROM foodwastedata WHERE waste_id = ?";
    $stmt = $conn->prepare($foodSql);
    $stmt->bind_param("i", $food_id);
    $stmt->execute();
    $foodResult = $stmt->get_result();
    $foodData = $foodResult->fetch_assoc();
    $stmt->close();

    if (!$foodData) {
        echo "Food not found!";
        exit;
    }
} else {
    echo "No food selected!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];

    $insertSql = "INSERT INTO food_requests (food_id, name, phone, address, email) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("issss", $food_id, $name, $phone, $address, $email);
    $stmt->execute();
    $stmt->close();

    header("Location: donate.php?food_id=" . $food_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Request</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Request Food</h1>
        <p>Food Category: <?php echo htmlspecialchars($foodData['food_category']); ?></p>
        <p>Amount Wasted: <?php echo htmlspecialchars($foodData['amount_wasted']); ?> KG</p>

        <form method="POST">
            <label for="name">Your Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>
            
            <label for="phone">Your Phone Number:</label><br>
            <input type="text" id="phone" name="phone" required><br><br>
            
            <label for="address">Your Address:</label><br>
            <textarea id="address" name="address" required></textarea><br><br>
            
            <label for="email">Your Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <input type="submit" value="Submit Request">
        </form>
    </div>
</body>
</html>
