<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin Panel</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
            <nav>
                <ul>
                    <li><a href="edit_user.php">Manage Users</a></li>
                    <li><a href="manage_food_requests.php">Manage Food Requests</a></li>
                    <li><a href="manage_programs.php">Manage Programs</a></li> 
                    <ul>
                    
</ul>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <h2>Dashboard</h2>
            <p>Here you can manage the system's users, food requests, and more.</p>
        </main>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> Food Waste Management System. All rights reserved by Fahad.</p>
        </footer>
    </div>
</body>
</html>
