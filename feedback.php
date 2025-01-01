<?php
session_start();
require 'connect.php'; 

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$rating = $comments = "";
$rating_err = $comments_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["rating"]))) {
        $rating_err = "Please select a rating.";
    } else {
        $rating = trim($_POST["rating"]);
    }

    if (empty(trim($_POST["comments"]))) {
        $comments_err = "Please enter your comments.";
    } else {
        $comments = trim($_POST["comments"]);
    }

    if (empty($rating_err) && empty($comments_err)) {
        $sql = "INSERT INTO feedback (user_id, rating, comments) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $user_id, $rating, $comments);

        if ($stmt->execute()) {
            echo "Thank you for your feedback!";
        } else {
            echo "Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
    <header>
        <h1>Submit Your Feedback</h1>
        <nav>
        <ul>
                <li><a href="home.php">Home</a></li>
                </ul>
        </nav>
        </header>

        <form method="POST" action="feedback.php">
            <label for="rating">Rating (1 to 5 stars):</label><br>
            <select id="rating" name="rating" required>
                <option value="1">1 Star</option>
                <option value="2">2 Stars</option>
                <option value="3">3 Stars</option>
                <option value="4">4 Stars</option>
                <option value="5">5 Stars</option>
            </select>
            <span class="error"><?php echo $rating_err; ?></span><br><br>

            <label for="comments">Comments:</label><br>
            <textarea id="comments" name="comments" required></textarea>
            <span class="error"><?php echo $comments_err; ?></span><br><br>

            <input type="submit" value="Submit Feedback">
        </form>
    </div>
</body>
</html>
