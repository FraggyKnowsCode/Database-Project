<?php
require 'connect.php';
session_start(); 

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: home.php"); 
    exit;
}

$programsSql = "SELECT * FROM reduction_programs";
$stmt = $conn->prepare($programsSql);
$stmt->execute();
$programsResult = $stmt->get_result();
$programs = $programsResult->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Programs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Manage Programs</h1>

        <h2>Add a New Program</h2>
        <form method="POST" action="programs.php">
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

        <h2>All Programs</h2>
        <table border="1">
            <tr>
                <th>Program Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Participating Organizations</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($programs as $program): ?>
                <tr>
                    <td><?php echo htmlspecialchars($program['program_name']); ?></td>
                    <td><?php echo htmlspecialchars($program['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($program['end_date']); ?></td>
                    <td><?php echo htmlspecialchars($program['participating_organizations']); ?></td>
                    <td>
                        <a href="edit_program.php?program_id=<?php echo $program['program_id']; ?>">Edit</a> |
                        <a href="delete_program.php?program_id=<?php echo $program['program_id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
