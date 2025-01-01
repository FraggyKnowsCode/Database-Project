<?php
require 'connect.php';

$programsSql = "SELECT * FROM reduction_programs";
$stmt = $conn->prepare($programsSql);
$stmt->execute();
$programsResult = $stmt->get_result();
$programs = $programsResult->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_program'])) {
    $program_name = $_POST['program_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $participating_organizations = $_POST['participating_organizations'];

    $insertSql = "INSERT INTO reduction_programs (program_name, start_date, end_date, participating_organizations) 
                  VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("ssss", $program_name, $start_date, $end_date, $participating_organizations);
    $stmt->execute();
    $stmt->close();

    header("Location: programs.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
        <h1>All Programs</h1>
        <nav>
        <ul>
                    <li><a href="home.php">Home</a></li>
                </ul>

        <h2>Add a New Program</h2>
        <form method="POST">
            <label for="program_name">Program Name:</label><br>
            <input type="text" id="program_name" name="program_name" required><br><br>

            <label for="start_date">Start Date:</label><br>
            <input type="date" id="start_date" name="start_date" required><br><br>

            <label for="end_date">End Date:</label><br>
            <input type="date" id="end_date" name="end_date" required><br><br>

            <label for="participating_organizations">Participating Organizations:</label><br>
            <textarea id="participating_organizations" name="participating_organizations" required></textarea><br><br>

            <input type="submit" name="add_program" value="Add Program">
        </form>

        <hr>

        <ul><li><a href="http://localhost/food_waste_management/costmanagement.php"?>Manage Cost</a></li>
    </ul>
</nav>
        </header>

        <h2>All Programs</h2>
        <table border="1">
            <tr>
                <th>Program Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Participating Organizations</th>
            </tr>
            <?php foreach ($programs as $program): ?>
                <tr>
                    <td><?php echo htmlspecialchars($program['program_name']); ?></td>
                    <td><?php echo htmlspecialchars($program['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($program['end_date']); ?></td>
                    <td><?php echo htmlspecialchars($program['participating_organizations']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
