<?php
require 'connect.php';

if (isset($_GET['program_id'])) {
    $program_id = $_GET['program_id'];

    $programSql = "SELECT * FROM reduction_programs WHERE program_id = ?";
    $stmt = $conn->prepare($programSql);
    $stmt->bind_param("i", $program_id);
    $stmt->execute();
    $programResult = $stmt->get_result();
    $program = $programResult->fetch_assoc();
    $stmt->close();

    if (!$program) {
        header("Location: programs.php");
        exit;
    }
} else {
    echo "No program selected!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_program'])) {
    $program_name = $_POST['program_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $participating_organizations = $_POST['participating_organizations'];

    $updateSql = "UPDATE reduction_programs SET program_name = ?, start_date = ?, end_date = ?, participating_organizations = ? WHERE program_id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ssssi", $program_name, $start_date, $end_date, $participating_organizations, $program_id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_programs.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Program</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Program</h1>

        <form method="POST">
            <label for="program_name">Program Name:</label><br>
            <input type="text" id="program_name" name="program_name" value="<?php echo htmlspecialchars($program['program_name']); ?>" required><br><br>

            <label for="start_date">Start Date:</label><br>
            <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($program['start_date']); ?>" required><br><br>

            <label for="end_date">End Date:</label><br>
            <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($program['end_date']); ?>" required><br><br>

            <label for="participating_organizations">Participating Organizations:</label><br>
            <textarea id="participating_organizations" name="participating_organizations" required><?php echo htmlspecialchars($program['participating_organizations']); ?></textarea><br><br>

            <input type="submit" name="update_program" value="Update Program">
        </form>
    </div>
</body>
</html>
