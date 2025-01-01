<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_firstName = $_SESSION["user_firstName"];
$user_lastName = $_SESSION["user_lastName"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Food Waste Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome, <?php echo htmlspecialchars($user_firstName . " " . $user_lastName); ?>!</h1>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="foodwastedata.php">Enter Food Waste Data</a></li>
                    <li><a href="foodwaste_table.php">Food Table</a></li>
                    <li><a href="donation.php">Donate Here</a></li>

                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <p>This is your dashboard. Here you can manage your activities in the Food Waste Management System.</p>
        </main>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> Food Waste Management System. All rights reserved by Fahad.</p>
        </footer>
    </div>
</body>
</html>
