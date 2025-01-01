<?php
require 'connect.php';

$programsSql = "SELECT * FROM reduction_programs";
$stmt = $conn->prepare($programsSql);
$stmt->execute();
$programsResult = $stmt->get_result();
$programs = $programsResult->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_cost'])) {
    $program_id = $_POST['program_id'];
    $labour_cost = $_POST['labour_cost'];
    $maintenance_cost = $_POST['maintenance_cost'];
    $transportation_cost = $_POST['transportation_cost'];
    $event_cost = $_POST['event_cost'];
    $other_cost = $_POST['other_cost'];

    $total_cost = $labour_cost + $maintenance_cost + $transportation_cost + $event_cost + $other_cost;

    $insertSql = "INSERT INTO cost_management (program_id, labour_cost, maintenance_cost, transportation_cost, event_cost, other_cost, total_cost)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("iiiiiii", $program_id, $labour_cost, $maintenance_cost, $transportation_cost, $event_cost, $other_cost, $total_cost);
    $stmt->execute();
    $stmt->close();

    header("Location: costmanagement.php?success=true");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Program Costs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
        <h1>Manage Program Costs</h1>
        <nav>
        <ul>
                    <li><a href="home.php">Home</a></li>
                </ul>
        
    
        <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
            <p style="color:green;">Cost entry added successfully!</p>
        <?php endif; ?>

        <h2>Add New Cost Entry</h2>
        <form method="POST">
            <label for="program_id">Select Program:</label><br>
            <select id="program_id" name="program_id" required>
                <option value="">Select a program</option>
                <?php foreach ($programs as $program): ?>
                    <option value="<?php echo $program['program_id']; ?>"><?php echo htmlspecialchars($program['program_name']); ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="labour_cost">Labour Cost:</label><br>
            <input type="number" id="labour_cost" name="labour_cost" min="0" step="0.01" required><br><br>

            <label for="maintenance_cost">Maintenance Cost:</label><br>
            <input type="number" id="maintenance_cost" name="maintenance_cost" min="0" step="0.01" required><br><br>

            <label for="transportation_cost">Transportation Cost:</label><br>
            <input type="number" id="transportation_cost" name="transportation_cost" min="0" step="0.01" required><br><br>

            <label for="event_cost">Event Cost:</label><br>
            <input type="number" id="event_cost" name="event_cost" min="0" step="0.01" required><br><br>

            <label for="other_cost">Other Cost:</label><br>
            <input type="number" id="other_cost" name="other_cost" min="0" step="0.01" required><br><br>

            <input type="submit" name="add_cost" value="Add Cost Entry">
        </form>

        <hr>
        </nav>
        </header>
        

        <h2>All Program Costs</h2>
        

        <table border="1">
            <tr>
                <th>Program Name</th>
                <th>Labour Cost</th>
                <th>Maintenance Cost</th>
                <th>Transportation Cost</th>
                <th>Event Cost</th>
                <th>Other Cost</th>
                <th>Total Cost</th>
                
            </tr>
            <?php
            $costSql = "SELECT cm.*, rp.program_name FROM cost_management cm
                        JOIN reduction_programs rp ON cm.program_id = rp.program_id";
            $stmt = $conn->prepare($costSql);
            $stmt->execute();
            $costResult = $stmt->get_result();
            $costs = $costResult->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            
            foreach ($costs as $cost):
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($cost['program_name']); ?></td>
                    <td><?php echo htmlspecialchars($cost['labour_cost']); ?> BDT</td>
                    <td><?php echo htmlspecialchars($cost['maintenance_cost']); ?> BDT</td>
                    <td><?php echo htmlspecialchars($cost['transportation_cost']); ?> BDT</td>
                    <td><?php echo htmlspecialchars($cost['event_cost']); ?> BDT</td>
                    <td><?php echo htmlspecialchars($cost['other_cost']); ?> BDT</td>
                    <td><?php echo htmlspecialchars($cost['total_cost']); ?> BDT</td>
                    
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
