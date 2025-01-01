<?php
require 'connect.php';

$sql = "SELECT Id, food_category, amount_wasted, cause_of_waste, location, disposal_method, date_of_waste, user_id, available FROM foodwastedata";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Waste Data - Food Waste Management</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <header>
            <h1>Food Data Table</h1>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="profile.php">Profile</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <?php
            if ($result->num_rows > 0) {
                echo '<table border="1">';
                echo '<tr>
                        <th>ID</th>
                        <th>Food Category</th>
                        <th>Amount Wasted (KG)</th>
                        <th>Cause of Waste</th>
                        <th>Location</th>
                        <th>Disposal Method</th>
                        <th>Date of Waste</th>
                        <th>User ID</th>
                        <th>Available</th>
                        <th>Phone Number</th>
                        <th>Request Food</th>
                      </tr>';

                $phoneSql = "SELECT phone FROM users WHERE id = ?";
                $stmt = $conn->prepare($phoneSql);

                while ($row = $result->fetch_assoc()) {
                    $stmt->bind_param("i", $row["user_id"]); 
                    $stmt->execute();
                    $resultPhone = $stmt->get_result();
                    $phone = $resultPhone->fetch_assoc()['phone'] ?? 'N/A'; 

                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["Id"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["food_category"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["amount_wasted"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["cause_of_waste"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["location"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["disposal_method"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["date_of_waste"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["user_id"]) . '</td>';
                    echo '<td>' . ($row["available"] ? 'Yes' : 'No') . '</td>'; 
                    echo '<td>' . htmlspecialchars($phone) . '</td>'; 
                    echo '<td><a href="foodrequest.php?food_id=' . $row["Id"] . '">Request Food</a></td>'; 
                    echo '</tr>';
                }

                echo '</table>';
            } else {
                echo "No data found.";
            }

            $stmt->close();
            $conn->close();
            ?>
        </main>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> Food Waste Management System. All rights reserved by Fahad.</p>
        </footer>
    </div>
</body>
</html>
