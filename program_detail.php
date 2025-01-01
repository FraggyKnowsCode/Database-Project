<?php
require 'connect.php';

if (isset($_GET['program_id'])) {
    $program_id = $_GET['program_id'];

    $programSql = "SELECT program_name, start_date, end_date, participating_organizations FROM reduction_programs WHERE program_id = ?";
    $stmt = $conn->prepare($programSql);
    $stmt->bind_param("i", $program_id);
    $stmt->execute();
    $programResult = $stmt->get_result();
    $programData = $programResult->fetch_assoc();
    $stmt->close();

    if (!$programData) {
        echo "Program not found!";
        exit;
    }

    $feedbackSql = "SELECT rating, comments, user_name, user_email, created_at FROM feedback WHERE program_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($feedbackSql);
    $stmt->bind_param("i", $program_id);
    $stmt->execute();
    $feedbackResult = $stmt->get_result();
    $feedbacks = $feedbackResult->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $avgRatingSql = "SELECT AVG(rating) AS average_rating FROM feedback WHERE program_id = ?";
    $stmt = $conn->prepare($avgRatingSql);
    $stmt->bind_param("i", $program_id);
    $stmt->execute();
    $avgRatingResult = $stmt->get_result();
    $avgRating = $avgRatingResult->fetch_assoc();
    $stmt->close();
} else {
    echo "No program selected!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Program Details: <?php echo htmlspecialchars($programData['program_name']); ?></h1>
        <p><strong>Start Date:</strong> <?php echo htmlspecialchars($programData['start_date']); ?></p>
        <p><strong>End Date:</strong> <?php echo htmlspecialchars($programData['end_date']); ?></p>
        <p><strong>Participating Organizations:</strong> <?php echo htmlspecialchars($programData['participating_organizations']); ?></p>

        <h2>Average Rating: <?php echo round($avgRating['average_rating'], 1); ?> / 5</h2>

        <h3>Feedback</h3>
        <?php if (count($feedbacks) > 0): ?>
            <?php foreach ($feedbacks as $feedback): ?>
                <div class="feedback">
                    <p><strong><?php echo htmlspecialchars($feedback['user_name']); ?></strong> (<?php echo htmlspecialchars($feedback['user_email']); ?>)</p>
                    <p>Rating: <?php echo $feedback['rating']; ?> / 5</p>
                    <p>Comments: <?php echo htmlspecialchars($feedback['comments']); ?></p>
                    <p><em>Submitted on <?php echo $feedback['created_at']; ?></em></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No feedback available yet.</p>
        <?php endif; ?>

        <h3>Provide Feedback:</h3>
        <p>Click <a href="feedback.php?program_id=<?php echo $program_id; ?>">here</a> to submit your feedback for this program.</p>
    </div>
</body>
</html>
