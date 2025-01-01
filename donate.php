<?php
require 'connect.php';

$foodSql = "SELECT Id, food_category FROM foodwastedata";
$stmt = $conn->prepare($foodSql);
$stmt->execute();
$foodResult = $stmt->get_result();
$foodItems = $foodResult->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if (isset($_POST['food_id'])) {
    $food_id = $_POST['food_id'];

    $foodSql = "SELECT food_category, amount_wasted FROM foodwastedata WHERE Id = ?";
    $stmt = $conn->prepare($foodSql);
    $stmt->bind_param("i", $food_id);
    $stmt->execute();
    $foodResult = $stmt->get_result();
    $foodData = $foodResult->fetch_assoc();
    $stmt->close();

    $requestSql = "SELECT name, phone, address, email FROM food_requests WHERE food_id = ? ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($requestSql);
    $stmt->bind_param("i", $food_id);
    $stmt->execute();
    $requestResult = $stmt->get_result();
    $requestData = $requestResult->fetch_assoc();
    $stmt->close();

    if (!$requestData) {
        $errorMessage = "No food request found for this food item!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate Food Request</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
        <h1>Food Request Details</h1>
        <nav>
        <ul>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="home.php">Home</a></li>
                </ul>

        <h2>Select a Food Item to View Request Details</h2>
        <form method="POST">
            <select name="food_id">
                <option value="">--Select Food--</option>
                <?php foreach ($foodItems as $foodItem): ?>
                    <option value="<?php echo $foodItem['Id']; ?>"><?php echo htmlspecialchars($foodItem['food_category']); ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="View Details">
        </form>
        </nav>
        </header>

        <?php if (isset($foodData) && isset($requestData)): ?>
            <h2>Requested Food</h2>
            <p>Food Category: <?php echo htmlspecialchars($foodData['food_category']); ?></p>
            <p>Amount Wasted: <?php echo htmlspecialchars($foodData['amount_wasted']); ?> KG</p>

            <h2>Requester Details</h2>
            <p>Name: <?php echo htmlspecialchars($requestData['name']); ?></p>
            <p>Phone: <?php echo htmlspecialchars($requestData['phone']); ?></p>
            <p>Address: <?php echo htmlspecialchars($requestData['address']); ?></p>
            <p>Email: <?php echo htmlspecialchars($requestData['email']); ?></p>
        <?php elseif (isset($errorMessage)): ?>
            <p><?php echo $errorMessage; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
